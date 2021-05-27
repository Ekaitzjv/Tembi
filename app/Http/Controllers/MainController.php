<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller{
    public function index(){
        return view('main');
    }

    //Página de cookies
    public function privacy(){
        return view('helps.privacy');
    }

    //Página de terminos
    public function terms(){
        return view('helps.terms');
    }
}
