<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $pendingMovies = Movie::where('status', 'pending')->with('creator')->latest()->get();
        $totalMovies = Movie::count();
        $totalUsers = \App\Models\User::count();

        return view('admin.dashboard', compact('pendingMovies', 'totalMovies', 'totalUsers'));
    }

    public function batchCreate(): View
    {
        return view('admin.movies.batch');
    }

    public function batchPreview(Request $request): View
    {
        $request->validate([
            'urls' => 'required|string',
        ]);

        $rawUrls = explode("\n", $request->input('urls'));
        $movies = [];

        foreach ($rawUrls as $url) {
            $url = trim($url);
            if (empty($url)) continue;

            $youtubeId = $this->extractYoutubeId($url);
            if (!$youtubeId) continue;

            $title = $this->fetchYoutubeTitle($url) ?? 'Unknown Title';

            $movies[] = [
                'youtube_id' => $youtubeId,
                'youtube_url' => $url,
                'title' => $title,
            ];
        }

        $genres = Genre::all();
        $casts = Cast::all();

        return view('admin.movies.batch-preview', compact('movies', 'genres', 'casts'));
    }

    public function batchStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'movies' => 'required|array',
            'movies.*.title' => 'required|string|max:255',
            'movies.*.youtube_id' => 'required|string|max:255',
            'movies.*.youtube_url' => 'required|url',
            'movies.*.year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'movies.*.description' => 'nullable|string',
            'movies.*.genres' => 'nullable|array',
            'movies.*.genres.*' => 'exists:genres,id',
            'movies.*.casts' => 'nullable|array',
            'movies.*.casts.*' => 'exists:casts,id',
        ]);

        $count = 0;
        foreach ($validated['movies'] as $movieData) {
            if (Movie::where('youtube_id', $movieData['youtube_id'])->exists()) {
                continue;
            }

            $movie = Movie::create([
                'title' => $movieData['title'],
                'youtube_id' => $movieData['youtube_id'],
                'description' => $movieData['description'] ?? null,
                'year' => $movieData['year'] ?? null,
                'status' => 'approved',
                'created_by' => auth()->id(),
            ]);

            if (!empty($movieData['genres'])) {
                $movie->genres()->attach($movieData['genres']);
            }

            if (!empty($movieData['casts'])) {
                $movie->castMembers()->attach($movieData['casts']);
            }

            $count++;
        }

        return redirect()->route('admin.movies.index')->with('status', "Successfully added {$count} movies in batch.");
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
        } catch (\Exception $e) {
            // Log error if needed
        }

        return null;
    }

    public function approveMovie(Movie $movie): RedirectResponse
    {
        $movie->update(['status' => 'approved']);

        return back()->with('status', "Movie '{$movie->title}' approved successfully.");
    }

    public function rejectMovie(Movie $movie): RedirectResponse
    {
        $movie->update(['status' => 'rejected']);

        return back()->with('status', "Movie '{$movie->title}' rejected.");
    }

    // Movie Management
    public function movies(): View
    {
        $movies = Movie::with('creator')->latest()->paginate(15);
        return view('admin.movies.index', compact('movies'));
    }

    public function editMovie(Movie $movie): View
    {
        $genres = Genre::all();
        $casts = Cast::all();
        $movie->load(['genres', 'castMembers']);
        
        return view('admin.movies.edit', compact('movie', 'genres', 'casts'));
    }

    public function updateMovie(Request $request, Movie $movie): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|url',
            'description' => 'nullable|string',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'status' => 'required|in:pending,approved,rejected',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
            'casts' => 'nullable|array',
            'casts.*' => 'exists:casts,id',
        ]);

        $youtubeId = $this->extractYoutubeId($validated['youtube_url']);

        if (! $youtubeId) {
            return back()->withErrors(['youtube_url' => 'Could not extract a valid YouTube Video ID.'])->withInput();
        }

        $movie->update([
            'title' => $validated['title'],
            'youtube_id' => $youtubeId,
            'description' => $validated['description'],
            'year' => $validated['year'],
            'status' => $validated['status'],
        ]);

        $movie->genres()->sync($validated['genres'] ?? []);
        $movie->castMembers()->sync($validated['casts'] ?? []);

        return redirect()->route('admin.movies.index')->with('status', 'Movie updated successfully.');
    }

    private function extractYoutubeId(string $url): ?string
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';

        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function deleteMovie(Movie $movie): RedirectResponse
    {
        $movie->delete();
        return back()->with('status', 'Movie deleted successfully.');
    }

    // Cast Management
    public function casts(): View
    {
        $casts = Cast::latest()->paginate(10);
        return view('admin.casts.index', compact('casts'));
    }

    public function storeCast(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = ['name' => $validated['name']];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('casts', 'public');
            $data['image'] = '/storage/' . $path;
        }

        Cast::create($data);

        return back()->with('status', 'Cast member added.');
    }

    // Genre Management
    public function genres(): View
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.genres.index', compact('genres'));
    }
}
