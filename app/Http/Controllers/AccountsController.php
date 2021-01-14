<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Collection;
use App\Http\Resources\Account as AccountResource;
use Symfony\Component\HttpFoundation\Response;

class AccountsController extends Controller
{/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Post $post) 
    {
        $user = auth()->user();
        return AccountResource::collection(Post::where('user_id' , $user->id)->get());
    }
}
