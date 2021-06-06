<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;

class UserController extends Controller{

    //SOLO VAN A PODER ACCEDER LOS USUARIOS LOGUEADOS (auth)
    public function __construct(){
        $this->middleware('auth');
    }

    
    public function index($search = null){
        //método del buscador
        if(!empty($search)){
            $users = User::where('username', 'LIKE', '%'.$search.'%')
                        ->orWhere('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('surname', 'LIKE', '%'.$search.'%')
                        ->orderBy('id', 'desc')
                        ->paginate(15);
        }else{
            //metodo de la página gente
            $users = User::orderBy('id', 'desc')->paginate(15);
        }
        
        return view('user.index', [
            'users' => $users
        ]);
    }

    public function edit(){
        return view('user.edit');
    }

    public function update(Request $request){

        //conseguir el usuario identificado
        $user = \Auth::user();
        $id = $user->id;

        //validación del formulario(comprobar lo básico)
        $validate = $this->validate($request, [  
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            //si el nombre de usuario coincide con el id entonces solo se hará la comprobación
            'username' => 'required|string|max:255|unique:users,surname,'.$id,
            'email' => 'required|string|max:255|email|unique:users,email,'.$id,
            'description' => 'max:255',
        ]);
        
        //Recoger datos del formulario
            //name = pido el nombre insertado(ejemplo)
        $id = \Auth::user()->id;
        $name = $request->input('name');
        $surname = $request->input('surname');
        $username = $request->input('username');
        $email = $request->input('email');
        $description = $request->input('description');
        
        //asignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->username = $username;
        $user->email = $email;
        $user->description = $description;

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

    //Perfil del usuario
    public function profile($id){
        $user = User::find($id);

        //Pasarle la variable $user al perfil
        return view('user.profile', [
            'user' => $user
        ]);
    }

    //Actividad de la cuenta y notificaciones
    public function activity(){
        //conseguir el usuario identificado y que solo pueda acceder el
        $id = \Auth::user()->id;
        $user = User::find($id);

        //Pasarle la variable $user al perfil
        return view('user.activity', [
            'user' => $user
        ]);
        
    }
}