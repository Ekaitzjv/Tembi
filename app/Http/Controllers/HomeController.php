<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Like;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //SOLO VAN A PODER ACCEDER LOS USUARIOS LOGUEADOS (auth)
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index(){
        //sacar todas las imagenes
        $posts = Post::orderBy('id', 'desc')->paginate(15);
        return view('home', [
            'posts' => $posts
            ]);
    }
}