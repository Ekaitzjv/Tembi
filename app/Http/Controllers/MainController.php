<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller{
    public function index(){
        return view('main');
    }

    //Página de privacidad
    public function privacy(){
        return view('helps.privacy');
    }

    //Página de politica de cookies
    public function cookies(){
        return view('helps.cookies');
    }

    //Página de más información
    public function more(){
        return view('helps.more');
    }
}
