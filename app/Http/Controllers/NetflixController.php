<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\View\View;

class NetflixController extends Controller
{
    public function landing(): View
    {
        return view('netflix.landing');
    }

    public function profiles()
    {
        return redirect()->route('browse');
    }

    public function browse(): View
    {
        return view('netflix.browse', $this->libraryData('Home'));
    }

    public function movies(): View
    {
        return view('netflix.movies', $this->libraryData('Movies'));
    }

    public function series(): View
    {
        return view('netflix.series', $this->libraryData('Series'));
    }

    public function newPopular(): View
    {
        return view('netflix.new-popular', $this->libraryData('New & Popular'));
    }

    public function myList(): View
    {
        $user = auth()->user();
        $movies = $user->watchlistMovies()->where('status', 'approved')->latest()->get();

        return view('netflix.my-list', [
            'page' => 'My List',
            'hero' => [
                'title' => 'My List',
                'description' => 'Your favorite movies and shows saved for later.',
                'backdrop' => $movies->first() ? "https://img.youtube.com/vi/{$movies->first()->youtube_id}/maxresdefault.jpg" : 'https://placehold.co/1600x900/0f172a/f8fafc?text=My+List',
                'movie' => $movies->first(),
            ],
            'rows' => [
                [
                    'title' => 'My Watchlist',
                    'items' => $movies,
                ]
            ],
        ]);
    }

    public function watch(Movie $movie): View
    {
        return view('netflix.watch', [
            'movie' => $movie,
        ]);
    }

    public function signIn()
    {
        return redirect()->route('login');
    }

    private function libraryData(string $page): array
    {
        $latestMovies = Movie::where('status', 'approved')->latest()->take(10)->get();
        $heroMovie = $latestMovies->first();

        $rows = [
            [
                'title' => 'Trending Now',
                'items' => $latestMovies,
            ],
        ];

        // Add dynamic rows based on genres
        $genres = Genre::with(['movies' => function($query) {
            $query->where('status', 'approved')->latest()->take(10);
        }])->get();

        foreach ($genres as $genre) {
            if ($genre->movies->isNotEmpty()) {
                $rows[] = [
                    'title' => $genre->name . ' Spotlight',
                    'items' => $genre->movies,
                ];
            }
        }

        return [
            'page' => $page,
            'hero' => [
                'title' => $heroMovie?->title ?? 'Habesha Originals',
                'description' => $heroMovie?->description ?? 'Stream trending Ethiopian movies, drama series, and stand-up specials in one place.',
                'backdrop' => $heroMovie ? "https://img.youtube.com/vi/{$heroMovie->youtube_id}/maxresdefault.jpg" : 'https://placehold.co/1600x900/0f172a/f8fafc?text=Featured+Show',
                'movie' => $heroMovie,
            ],
            'rows' => $rows,
        ];
    }
}
