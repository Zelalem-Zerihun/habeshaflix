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
