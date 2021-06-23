<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Post;
use App\Comment;
use App\Like;
use App\User;
use App\Report;

class PostController extends Controller
{
    //solo los usuarios logueados
    public function __construct(){
        $this->middleware('auth');
    }

    //formulario para crear imagenes
    public function create(){
        return view('image.create');
    }

    //formulario para guardar las imagenes
    public function save(Request $request){

        //Validación
        $validate = $this->validate($request, [
            'description' => 'max:255',
            'image_path' => 'mimes:jpeg,png,jpg|required|image|max:10240'
        ]);

        //recojer los datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //asignar valores al nuevo objeto
        $user = \Auth::user();
        $post = new Post();
        $post->user_id = $user->id;
        $post->description = $description;
        $post->all_likes = 0;

        //subir imagen
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $post->image_path = $image_path_name;
        }

        $post->save();
    
        return redirect()->route('home')->with([
            'message' => 'The photo has been uploaded successfully'
        ]);
    }

    //Coger las imagenes para mostrarlas
    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    //Ver imagen
    public function view($id){
        $post = Post::find($id);

        if($post){
            return view('image.view',[
                'post' => $post
            ]);
        }else{
            return redirect()->route('home');
        }
    }
    
    //Mostrar página individual de la imagen
    public function detail($id){
        $post = Post::find($id);

        if($post){
            return view('image.detail',[
                'post' => $post
            ]);
        }else{
            return redirect()->route('home');
        }
        
    }

    //Eliminar imagen
    public function delete($id){
        $user = \Auth::user();
        //sacar la imagen que necesito por id
        $post = Post::find($id);
        //sacar todos los comentarios de la imagen por el id
        $comments = Comment::where('post_id', $id)->get();
        //sacar todos los likes de la imagen por el id
        $likes = Like::where('post_id', $id)->get();

        //Comprobar que soy el dueño de la imagen
        if($user && $post && $post->user->id == $user->id){

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

            //Eliminar ficheros de imagen guardados en el storage y en la ddbb
            Storage::disk('images')->delete($post->image_path);
            //Eliminar registro de la imagen
            $post->delete();

            $message = array('message' => 'Image removed correctly');

        }else{
            $message = array('message' => 'The image was not removed correctly');
        }
        return redirect()->route('home')->with($message);
    }

    //Editar imagen
    public function edit($id){
        $user = \Auth::user();
        $post = Post::find($id);

        if($user && $post && $post->user->id == $user->id){
            return view('image.edit', [
                'post' => $post
            ]);
        }else{
            return redirect()->route('home');
        }
    }

    //Actualizar imagen
    public function update(Request $request){
        //Validación
        $validate = $this->validate($request, [
            'description' => '',
            'image_path' => 'image'
        ]);

        //Recoger datos
        $post_id = $request->input('post_id');
        $description = $request->input('description');
        
        //Conseguir objeto image
        $post = Post::find($post_id);
        $post->description = $description;

        //Actualizar registro
        $post->update();

        return redirect()->route('image.detail', ['id' => $post_id])
                        ->with(['message' => 'Image updated correctly']);
    }

    public function report($post_id){
        $report = new Report();
        $user = \Auth::user();

        $report->user_id = $user->id;
        $report->post_id = (int)$post_id;

        //Guardar en la base de datos el reporte
        $report->save();

        return redirect()->route('image.detail', ['id' => $post_id])
                        ->with(['message' => 'Image reported correctly']);
    }

    //Imagenes populares
    public function trendy(){

        $user = \Auth::user();
        
        //sacar las 10 imagenes con más likes 
        $posts = Post::where('all_likes', '>', 0)
                        ->orderBy('all_likes', 'desc')
                        ->limit(10)
                        ->get();
    
        return view('image.trendy', [
            'posts' => $posts
        ]);
    }
}