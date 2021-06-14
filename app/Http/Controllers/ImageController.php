<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Comment;
use App\Like;
use App\User;
use App\Report;

class ImageController extends Controller
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
        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;
        $image->all_likes = 0;

        //subir imagen
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->save();
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
        $image = Image::find($id);

        if($image){
            return view('image.view',[
                'image' => $image
            ]);
        }else{
            return redirect()->route('home');
        }
    }
    
    //Mostrar página individual de la imagen
    public function detail($id){
        $image = Image::find($id);

        if($image){
            return view('image.detail',[
                'image' => $image
            ]);
        }else{
            return redirect()->route('home');
        }
        
    }

    //Eliminar imagen
    public function delete($id){
        $user = \Auth::user();
        //sacar la imagen que necesito por id
        $image = Image::find($id);
        //sacar todos los comentarios de la imagen por el id
        $comments = Comment::where('image_id', $id)->get();
        //sacar todos los likes de la imagen por el id
        $likes = Like::where('image_id', $id)->get();

        //Comprobar que soy el dueño de la imagen
        if($user && $image && $image->user->id == $user->id){

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
            Storage::disk('images')->delete($image->image_path);
            //Eliminar registro de la imagen
            $image->delete();

            $message = array('message' => 'Image removed correctly');

        }else{
            $message = array('message' => 'The image was not removed correctly');
        }
        return redirect()->route('home')->with($message);
    }

    //Editar imagen
    public function edit($id){
        $user = \Auth::user();
        $image = Image::find($id);

        if($user && $image && $image->user->id == $user->id){
            return view('image.edit', [
                'image' => $image
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
        $image_id = $request->input('image_id');
        $description = $request->input('description');
        
        //Conseguir objeto image
        $image = Image::find($image_id);
        $image->description = $description;

        //Actualizar registro
        $image->update();

        return redirect()->route('image.detail', ['id' => $image_id])
                        ->with(['message' => 'Image updated correctly']);
    }

    public function report($image_id){
        $report = new Report();
        $user = \Auth::user();

        $report->user_id = $user->id;
        $report->image_id = (int)$image_id;

        //Guardar en la base de datos el reporte
        $report->save();

        return redirect()->route('image.detail', ['id' => $image_id])
                        ->with(['message' => 'Image reported correctly']);
    }

    //Imagenes populares
    public function trendy(){

        $user = \Auth::user();
        $images = new Like();
        
        //sacar las 10 imagenes con más likes 
        $images = Image::where('all_likes', '>', 0)
                        ->orderBy('all_likes', 'desc')
                        ->limit(10)
                        ->get();
    
        return view('image.trendy', [
            'images' => $images
        ]);
    }
}