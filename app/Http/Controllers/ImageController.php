<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;

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
            'description' => '',
            'image_path' => 'required|image'
        ]);
        
        //recojer los datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //asignar valores al nuevo objeto
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;

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

    //Mostrar página individual de la imagen
    public function detail($id){
        $image = Image::find($id);

        return view('image.detail',[
            'image' => $image
        ]);
    }
}