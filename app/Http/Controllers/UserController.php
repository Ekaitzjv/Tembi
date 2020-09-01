<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit(){
        return view('user.edit');
    }

    public function update(Request $request){
        $id =\Auth::user()->id;
        $email =\Auth::user()->email;

        $validate = $this->validate($request, [  
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            //si el nombre de usuario coincide con el id entonces solo se hará la comprobación
            'username' => 'required|string|max:255|unique:users,surname,'.$id,
            'email' => 'required|string|max:255|email|unique:users,email,'.$id,
        ]);

        $id = \Auth::user()->id;
        $name = $request->input('name');
        $surname = $request->input('surname');
        $username = $request->input('username');
        $email = $request->input('email');


    }
}
