<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Image;
use App\User;

class LikeController extends Controller{
    public function __construct(){
        //SOLO VAN A PODER ACCEDER LOS USUARIOS LOGUEADOS (auth)
        $this->middleware('auth');
    }

    //Listar todas las publicaciones a las que les he dado like
    public function index(){
        $user = \Auth::user();
        $likes = Like::where('user_id', $user->id)->orderBy('id', 'desc')
                    ->paginate(15);
        return view('like.index', [
            'likes' => $likes
        ]);
    }

    //Guardar un like
    public function like($image_id){
        //Recoger datos del usuario y de la imagen
        $user = \Auth::user();

        //Condición para ver si ya existe el like y no duplicarlo
                                //user_id es igual a $user->id
        $isset_like = Like::where('user_id', $user->id)
                                //image_id es igual a $image_id
                            ->where('image_id', $image_id)
        //contar los likes totales en una publicacion heachos por el usuario logueado
                            ->count();

        //Hacer like cuando es 0 la cantidad de likes
        if($isset_like == 0){
            $like = new Like();
            $image = new Image();

            $like->user_id = $user->id;
            $like->image_id = (int)$image_id;
            
            //Sumar 1 like en la tabla images
            $image = Image::find($image_id);
            $image->all_likes = $image->all_likes + 1;

            //Sumar 1 like en la tabla de usuarios
            $id = $image->user_id;
            $user = User::find($id);
            if($user->all_likes >= 0){
                $user->all_likes = $user->all_likes + 1;
            }
            
            //Guardar en la base de datos el objeto
            $like->save();
            $image->update();
            $user->update();

            return response()->json([
                'like' => $like
            ]);

        }else{
            return response()->json([
                'message' => 'El like ya existe, no puede haber 2'
            ]);
        }
    }

    //Borrar un like
    public function dislike($image_id){
    //Recoger datos del usuario y de la imagen
    $user = \Auth::user();

    //Condición para ver si ya existe el like, para poder hacer dislike
                             //user_id es igual a $user->id
    $like = Like::where('user_id', $user->id)
                             //image_id es igual a $image_id
                        ->where('image_id', $image_id)
                        //
                        ->first();

        //si exite like, lo borramos
        if($like){

            //Restar 1 like en la tabla images
            $image = Image::find($image_id);
            $image->all_likes = $image->all_likes - 1;

            //Restar 1 like en la tabla de usuarios
            $id = $image->user_id;
            $user = User::find($id);
            if($user->all_likes > 0){
                $user->all_likes = $user->all_likes - 1;
            }

            //Eliminar like
            $like->delete();
            $image->update();
            $user->update();

            return response()->json([
                'like' => $like,
                'message' => 'dislike correctamente'
            ]);
        }else{
            return response()->json([
                'message' => 'El like no existe'
            ]);
        }
    }

}