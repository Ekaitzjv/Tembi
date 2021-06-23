<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;
use App\Post;
use App\Like;
use App\Comment;
use App\Report;

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

    /*Administrador*/
    public function admin(){
        $user = \Auth::user();

        //sacar todas las imagenes
        $posts = Post::get();
        //sacar todos los usuarios
        $users = User::get();
        //sacar todos los usuarios
        $likes = Like::get();
        //sacar todos los usuarios
        $comments = Comment::get();
        //sacar todos los usuarios
        $reports = Report::get();

        if($user->role == '1234'){
            return view('admin.index',[
                'posts' => $posts,
                'users' => $users,
                'likes' => $likes,
                'comments' => $comments,
                'reports' => $reports
            ]);

        }else{
            return redirect()->route('home');
        }
    }

    public function reports(){
        $user = \Auth::user();

        $report = Report::get();
        
        if($user->role == '1234'){
            return view('admin.reports',[
                'report' => $report
            ]);
            
        }else{
            return redirect()->route('home');
        }
    }

    //Eliminar perfil de persona denunciada
    public function ReportUserDelete($id){
            
            $user = User::find($id);

            if(User::find($id)){
                //Borrar los comentarios, likes y reportes hechos por el usuario
                $comments = Comment::where('user_id', $id)->get();
                $likes = Like::where('user_id', $id)->get();
                $reports = Report::where('user_id', $id)->get();

                    //Eliminar comentarios
                    if($comments && count($comments) >= 1){
                        foreach($comments as $comment){
                            $comment->delete();
                        }
                    }
                    
                    //Eliminar likes
                    if($likes && count($likes) >= 1){
                        foreach($likes as $like){
                            $like->delete();
                        }
                    }

                    //Eliminar reportes
                    if($reports && count($reports) >= 1){
                        foreach($reports as $report){
                            $report->delete();
                        }
                    }
                
                //Borrar comentarios y likes de las publicaciones del usuario
                $id = $user->id;
                $posts = Post::where('user_id', $id)->get();

                foreach($posts as $post){
                    //sacar el id de cada imagen del usuario
                    $id = $post->id;
                    $comments = Comment::where('post_id', $id)->get();
                    $likes = Like::where('post_id', $id)->get();
                    $reports = Report::where('post_id', $id)->get();

                    //Eliminar comentarios
                    if($comments && count($comments) >= 1){
                        foreach($comments as $comment){
                            $comment->delete();
                        }
                    }
                    
                    //Eliminar likes
                    if($likes && count($likes) >= 1){
                        foreach($likes as $like){
                            $like->delete();
                        }
                    }

                    //Eliminar reportes que le hayan hecho al usuario
                    if($reports && count($reports) >= 1){
                        foreach($reports as $report){
                            $report->delete();
                        }
                    }
                }
                
                //Eliminar publicaciones del usuario
                if($posts && count($posts) >= 1){
                    foreach($posts as $post){
                        $post->delete();
                        Storage::disk('images')->delete($post->image_path);
                    }
                }
                //Borrar usuario
                $user->delete(); 
                return redirect()->route('reports');
        }
    }
    
    //Eliminar post denunciado
    public function ReportPostDelete($id){
        $user = \Auth::user();
        //sacar la imagen que necesito por id
        $post = Post::find($id);
        //sacar todos los comentarios de la imagen por el id
        $comments = Comment::where('post_id', $id)->get();
        //sacar todos los likes de la imagen por el id
        $likes = Like::where('post_id', $id)->get();
        //sacar todos los reportes de la imagen por el id
        $reports = Report::where('post_id', $id)->get();

        //Comprobar que soy el admin
        if($user && $post && $user->role == '1234'){

            //Eliminar comentarios
            if($comments && count($comments) >= 1){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }
            
            //Eliminar likes
            if($likes && count($likes) >= 1){
                foreach($likes as $like){
                    $like->delete();
                }
            }

            //Eliminar reportes
            if($reports && count($reports) >= 1){
                foreach($reports as $report){
                    $report->delete();
                }
            }

            //Eliminar ficheros de imagen guardados en el storage y en la ddbb
            Storage::disk('images')->delete($post->image_path);
            //Eliminar registro de la imagen
            $post->delete();
        }
        return redirect()->route('reports');
    }

    //Eliminar post denunciado
    public function ReportCancel($id){
        $user = \Auth::user();

        //sacar el reporte
        $report = Report::find($id);

        //Comprobar que soy el admin
        if($user && $report && $user->role == '1234'){
            //Eliminar registro de la imagen
            $report->delete();
        }
        return redirect()->route('reports');
    }

    /*Editar perfil*/
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

    public function delete($id){

        if($id != \Auth::user()->id){
            return redirect()->route('home')
            ->with([
            'message' => 'You are not allowed to delete that user'
            ]);
        }

        if(User::find($id)){
            $user = \Auth::user($id);

            //Borrar los comentarios, likes y reportes hechos por el usuario
            $comments = Comment::where('user_id', $id)->get();
            $likes = Like::where('user_id', $id)->get();
            $reports = Report::where('user_id', $id)->get();

            //Eliminar comentarios
            if($comments && count($comments) >= 1){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }
                
            //Eliminar likes
            if($likes && count($likes) >= 1){
                foreach($likes as $like){
                    $like->delete();
                }
            }

            //Eliminar reportes
            if($reports && count($reports) >= 1){
                foreach($reports as $report){
                     $report->delete();
                }
            }

            //Borrar comentarios y likes de las publicaciones del usuario
            $posts = Post::where('user_id', $id)->get();

            foreach($posts as $post){
                //sacar el id de cada imagen del usuario
                $id = $post->id;
                $comments = Comment::where('post_id', $id)->get();
                $likes = Like::where('post_id', $id)->get();
                $reports = Report::where('post_id', $id)->get();
    
                //Eliminar comentarios
                if($comments && count($comments) >= 1){
                    foreach($comments as $comment){
                        $comment->delete();
                    }
                }
                    
                //Eliminar likes
                if($likes && count($likes) >= 1){
                    foreach($likes as $like){
                        $like->delete();
                    }
                }
    
                //Eliminar reportes
                if($reports && count($reports) >= 1){
                    foreach($reports as $report){
                        $report->delete();
                    }
                }
            }

            //Eliminar publicaciones del usuario
            if($posts && count($posts) >= 1){
                foreach($posts as $post){
                    $post->delete();
                    Storage::disk('images')->delete($post->image_path);
                }
            }

            //Borrar usuario
            $user->delete(); 
            return redirect()->route('main');
         }
    }

    //devolver imagen
    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }

    //Perfil del usuario
    public function profile($id){
        $user = User::find($id);

        if($user){
            //Pasarle la variable $user al perfil
            return view('user.profile', [
                'user' => $user
            ]);
        }else{
            return redirect()->route('home');
        }
    }

    //Actividad de la cuenta y notificaciones
    public function activity(){
        //conseguir el usuario identificado y que solo pueda acceder el
        $user = \Auth::user();

        $likes = 0;
        $comments = 0;

        foreach($user->posts as $post){
            $post_id = $post->id;

            $likes = Like::where('post_id', $post_id)->count();
            $comments = Comment::where('post_id', $post_id)->count();

            if($likes > 0 || $comments > 0){
                //Pasarle la variable $user al perfil
               return view('user.activity', [
                   'user' => $user
               ]);
            }
        }
        
        if($likes > 0 || $comments > 0){
             //Pasarle la variable $user al perfil
            return view('user.activity', [
                'user' => $user
            ]);
            
        }else{
            return view('user.no-activity');
        }
    }
}