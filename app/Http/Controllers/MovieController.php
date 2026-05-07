<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(): View
    {
        $movies = Movie::query()
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('movies.index', [
            'movies' => $movies,
        ]);
    }

    public function create(): View
    {
        $genres = \App\Models\Genre::all();
        $casts = \App\Models\Cast::all();

        return view('movies.create', compact('genres', 'casts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['required', 'string', 'url'],
            'description' => ['nullable', 'string'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:'.(date('Y') + 5)],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['exists:genres,id'],
            'casts' => ['nullable', 'array'],
            'casts.*' => ['exists:casts,id'],
        ]);

        $youtubeId = $this->extractYoutubeId($validated['youtube_url']);

        if (! $youtubeId) {
            return back()->withErrors(['youtube_url' => 'Could not extract a valid YouTube Video ID.'])->withInput();
        }

        // Check if movie already exists
        if (Movie::where('youtube_id', $youtubeId)->exists()) {
            return back()->withErrors(['youtube_url' => 'This movie has already been submitted.'])->withInput();
        }

        $title = $validated['title'];
        if (empty($title)) {
            $title = $this->fetchYoutubeTitle($validated['youtube_url']);
        }

        if (empty($title)) {
            return back()->withErrors(['title' => 'The title field is required when it cannot be fetched from YouTube.'])->withInput();
        }

        $movie = Movie::create([
            'title' => $title,
            'youtube_id' => $youtubeId,
            'description' => $validated['description'],
            'year' => $validated['year'],
            'created_by' => $request->user()->id,
            'status' => 'pending',
        ]);

        if (! empty($validated['genres'])) {
            $movie->genres()->attach($validated['genres']);
        }

        if (! empty($validated['casts'])) {
            $movie->castMembers()->attach($validated['casts']);
        }

        return redirect()->route('home')->with('status', 'Movie submitted successfully and is awaiting approval.');
    }

    public function fetchTitle(Request $request)
    {
        $url = $request->query('url');
        if (! $url) {
            return response()->json(['error' => 'URL is required'], 400);
        }

        \Log::info('Fetching YouTube title for URL: ' . $url);
        $title = $this->fetchYoutubeTitle($url);

        if (! $title) {
            \Log::warning('Could not fetch title for URL: ' . $url);
            return response()->json(['error' => 'Could not fetch title from YouTube'], 422);
        }

        \Log::info('Successfully fetched title: ' . $title);
        return response()->json(['title' => $title]);
    }

    public function generateDescription(Request $request)
    {
        $url = $request->query('url');
        $title = $request->query('title');
        $casts = $request->query('casts');
        
        if (! $url) {
            return response()->json(['error' => 'URL is required'], 400);
        }

        $apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');
        if (! $apiKey) {
            return response()->json(['error' => 'Gemini API key not configured'], 500);
        }

        $castContext = $casts ? " starring " . $casts : "";
        $prompt = "Act as a professional Netflix Content Editor: Analyze the Amharic movie titled '" . ($title ?? 'Unknown Title') . "'" . $castContext . " at the following YouTube link and provide a cinematic metadata package entirely in Amharic, consisting ONLY of a one-sentence Logline hook and a 2-3 sentence Synopsis teaser. Ensure the description matches the specific content of this movie and mentions the main cast members if appropriate. Movie Link: " . $url;

        try {
            \Log::info('Calling Gemini API for Movie: ' . ($title ?? 'Unknown') . ' - Casts: ' . ($casts ?? 'None') . ' - URL: ' . $url);
            // Updated to gemini-2.5-flash as requested
            $response = Http::withoutVerifying()->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $description = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
                
                if ($description) {
                    \Log::info('Gemini description generated successfully');
                    return response()->json(['description' => $description]);
                }
                
                \Log::warning('Gemini response successful but no text found: ' . json_encode($result));
            }

            $errorBody = $response->body();
            \Log::error('Gemini API failed: ' . $response->status() . ' - ' . $errorBody);
            
            $errorMessage = 'Could not generate description from Gemini';
            $jsonError = json_decode($errorBody, true);
            if (isset($jsonError['error']['message'])) {
                $errorMessage .= ': ' . $jsonError['error']['message'];
            }

            return response()->json(['error' => $errorMessage], 422);
        } catch (\Exception $e) {
            \Log::error('Gemini API exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while calling Gemini API'], 500);
        }
    }

    public function show(Movie $movie): View
    {
        abort_unless($movie->status === 'approved' || (auth()->check() && (auth()->user()->isAdmin() || auth()->id() === $movie->created_by)), 404);

        $movie->load(['genres', 'castMembers', 'creator']);

        return view('movies.show', [
            'movie' => $movie,
        ]);
    }

    private function fetchYoutubeTitle(string $url): ?string
    {
        try {
            $response = Http::withoutVerifying()->get('https://www.youtube.com/oembed', [
                'url' => $url,
                'format' => 'json',
            ]);

            if ($response->successful()) {
                return $response->json('title');
            }
            
            \Log::error('YouTube oEmbed failed: ' . $response->status() . ' - ' . $response->body());
        } catch (\Exception $e) {
            \Log::error('YouTube oEmbed exception: ' . $e->getMessage());
        }

        return null;
    }

    private function extractYoutubeId(string $url): ?string
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';

        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
