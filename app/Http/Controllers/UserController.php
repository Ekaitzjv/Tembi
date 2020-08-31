<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit(){
        return view('user.edit');
    }

    public function update(Request $request){
        //conseguir usuario indetificado 
        $user = \Auth::user();
        $id = $user->id;

        //validación del formulario
        $validate = $this->validate($request, [  
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            //si el nombre de usuario coincide con el id entonces solo se hará la comprobación
            'username' => 'required|string|max:255|unique:users,surname,'.$id,
            'email' => 'required|string|max:255|email|unique:users,email,'.$id,
        ]);
        
        //recoger datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $username = $request->input('username');
        $email = $request->input('email');
        
        //Asignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->username = $username;
        $user->email = $email;

        //Ejecutar consulta y cambios en la base de datos
        $user->update();

        return redirect()->route('edit')
                         ->with(['message'=>'User updated successfully']);


    }
}