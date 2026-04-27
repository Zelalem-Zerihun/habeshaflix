<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'title' => ['required', 'string', 'max:255'],
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

        $movie = Movie::create([
            'title' => $validated['title'],
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

    public function show(Movie $movie): View
    {
        abort_unless($movie->status === 'approved' || (auth()->check() && (auth()->user()->isAdmin() || auth()->id() === $movie->created_by)), 404);

        $movie->load(['genres', 'castMembers', 'creator']);

        return view('movies.show', [
            'movie' => $movie,
        ]);
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
