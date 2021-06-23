<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Post;
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
    public function like($post_id){
        //Recoger datos del usuario y de la imagen
        $user = \Auth::user();

        //Condición para ver si ya existe el like y no duplicarlo
                                //user_id es igual a $user->id
        $isset_like = Like::where('user_id', $user->id)
                                //image_id es igual a $image_id
                            ->where('post_id', $post_id)
        //contar los likes totales en una publicacion heachos por el usuario logueado
                            ->count();

        //Hacer like cuando es 0 la cantidad de likes
        if($isset_like == 0){
            $like = new Like();

            $like->user_id = $user->id;
            $like->post_id = (int)$post_id;
            
            //Sumar 1 like en la tabla images
            $image = Post::find($post_id);
            $image->all_likes = $image->all_likes + 1;
            
            //Guardar en la base de datos el objeto
            $like->save();
            $image->update();

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
    public function dislike($post_id){
    //Recoger datos del usuario y de la imagen
    $user = \Auth::user();

    //Condición para ver si ya existe el like, para poder hacer dislike
                             //user_id es igual a $user->id
    $like = Like::where('user_id', $user->id)
                             //image_id es igual a $image_id
                        ->where('post_id', $post_id)
                        //
                        ->first();

        //si exite like, lo borramos
        if($like){

            //Restar 1 like en la tabla images
            $image = Post::find($post_id);
            $image->all_likes = $image->all_likes - 1;

            //Eliminar like
            $like->delete();
            $image->update();

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