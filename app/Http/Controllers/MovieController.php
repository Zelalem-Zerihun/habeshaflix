<?php

namespace App\Http\Controllers;

use App\Models\Movie;
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

    public function show(Movie $movie): View
    {
        abort_unless($movie->status === 'approved', 404);

        $movie->load(['genres', 'castMembers', 'creator']);

        return view('movies.show', [
            'movie' => $movie,
        ]);
    }
}
