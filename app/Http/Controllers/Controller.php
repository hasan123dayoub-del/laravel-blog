<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    public function myFavorites()
{
    $user = Auth::user();

    return response()->json([
        'Favorites' => $user->favorites
    ], 200);
}

}
