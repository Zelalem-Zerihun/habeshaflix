<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class NetflixController extends Controller
{
    public function landing(): View
    {
        return view('netflix.landing');
    }

    public function profiles(): View
    {
        return view('netflix.profiles', [
            'profiles' => [
                ['name' => 'Family', 'image' => 'https://placehold.co/180x180/ef4444/ffffff?text=Family'],
                ['name' => 'Kids', 'image' => 'https://placehold.co/180x180/22c55e/ffffff?text=Kids'],
                ['name' => 'Zola', 'image' => 'https://placehold.co/180x180/3b82f6/ffffff?text=Zola'],
                ['name' => 'Guest', 'image' => 'https://placehold.co/180x180/f59e0b/ffffff?text=Guest'],
            ],
        ]);
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
        return view('netflix.my-list', $this->libraryData('My List'));
    }

    public function watch(string $slug = 'featured-trailer'): View
    {
        return view('netflix.watch', [
            'slug' => str_replace('-', ' ', $slug),
            'poster' => 'https://placehold.co/1200x675/111827/e5e7eb?text=Now+Playing',
        ]);
    }

    public function signIn(): View
    {
        return view('netflix.signin');
    }

    private function libraryData(string $page): array
    {
        return [
            'page' => $page,
            'hero' => [
                'title' => 'Habesha Originals',
                'description' => 'Stream trending Ethiopian movies, drama series, and stand-up specials in one place.',
                'backdrop' => 'https://placehold.co/1600x900/0f172a/f8fafc?text=Featured+Show',
            ],
            'rows' => [
                [
                    'title' => 'Trending Now',
                    'items' => $this->makeCards('Trending', 8),
                ],
                [
                    'title' => 'Top Picks For You',
                    'items' => $this->makeCards('Top Pick', 8),
                ],
                [
                    'title' => 'Action & Adventure',
                    'items' => $this->makeCards('Action', 8),
                ],
                [
                    'title' => 'Drama Spotlight',
                    'items' => $this->makeCards('Drama', 8),
                ],
            ],
        ];
    }

    private function makeCards(string $prefix, int $count): array
    {
        $items = [];

        for ($i = 1; $i <= $count; $i++) {
            $items[] = [
                'title' => "{$prefix} {$i}",
                'image' => "https://placehold.co/320x180/1f2937/f9fafb?text={$prefix}+{$i}",
            ];
        }

        return $items;
    }
}
