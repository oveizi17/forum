<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{


    /**
     * FavoritesController constructor.
     */
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
       $reply->makeFavorited();
    }
}
