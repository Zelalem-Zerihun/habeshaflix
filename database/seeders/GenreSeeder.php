<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Action',
            'Comedy',
            'Drama',
            'Horror',
            'Sci-Fi',
            'Thriller',
            'Documentary',
            'Animation',
            'Romance',
            'Fantasy',
            'Mystery',
            'Adventure',
            'Crime',
        ];

        foreach ($genres as $genre) {
            Genre::firstOrCreate(['name' => $genre]);
        }
    }
}
