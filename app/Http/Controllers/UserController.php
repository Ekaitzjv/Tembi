<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function edit(){
        return view('user.edit');
    }

    public function update(Request $request){

        //conseguir el usuario identificado
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
        
        //Recoger datos del formulario
        $id = \Auth::user()->id;
        $name = $request->input('name');
        $surname = $request->input('surname');
        $username = $request->input('username');
        $email = $request->input('email');
        
        //asignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->username = $username;
        $user->email = $email;

        //subir la imagen
        $image_path = $request->file('image_path');
        if($image_path){
            //Poner nombre único
            $image_path_name = time().$image_path->getClientOriginalName();
            //Guardarla en la carpeta storage (storage/app/users)
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            //setear el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }

        //ejecutar consulta y cambios en la ddbb
        $user->update();

        return redirect()->route('edit')
                         ->with(['message'=>'User updated successfully']);
    }

    //devolver imagen
    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }
}