<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct(){
        //SOLO VAN A PODER ACCEDER LOS USUARIOS LOGUEADOS (auth)
        $this->middleware('auth');
    }

    //Página de principal de configuración de la cuenta
    public function index(){
        return view('settings.index');
    }
}
