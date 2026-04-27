<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Watchlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function toggle(Request $request, Movie $movie): RedirectResponse
    {
        $user = $request->user();
        
        $exists = Watchlist::where('user_id', $user->id)
            ->where('movie_id', $movie->id)
            ->first();

        if ($exists) {
            $exists->delete();
            $status = 'Removed from My List';
        } else {
            Watchlist::create([
                'user_id' => $user->id,
                'movie_id' => $movie->id,
            ]);
            $status = 'Added to My List';
        }

        return back()->with('status', $status);
    }
}
