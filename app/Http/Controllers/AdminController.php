<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
