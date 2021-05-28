<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller{

    //Página de principal de Log In y register
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

    //Página de ayuda de politicas de privacidad
    public function help(){
        return view('helps.help');
    }
}
