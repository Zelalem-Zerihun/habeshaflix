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
