<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Image;
use App\User;

class CommentController extends Controller
{
    //solo los usuarios logueados
    public function __construct(){
        $this->middleware('auth');
    }

    //Validación
    public function save(Request $request){

        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);

        //Recoger datos del formulario
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');
        
        //Asigno valores a mi nuevo objeto
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        
        //Sumar 1 comentario en la tabla de usuarios
        $image_id = $comment->image_id;
        $image = Image::find($image_id);
        $id = $image->user_id;

        $user = User::find($id);
        if($user->all_comments >= 0){
            $user->all_comments = $user->all_comments + 1;
        }

        //Guardar en DB
        $comment->save();
        $user->update();

        //Redirección
        return redirect()->route('image.detail', ['id' => $image_id])
                         ->with([
                            'message' => 'Comment posted correctly'
                         ]);
    }

    //Borrar comentarios
    public function delete($id){
        //Conseguir datos del usuario identificado
        $user = \Auth::user();

        //Conseguir objeto del comentario
        $comment = Comment::find($id);

        //Restar 1 comentario en la tabla de usuarios
        $image_id = $comment->image_id;
        $image = Image::find($image_id);
        $id = $image->user_id;

        $user = User::find($id);
        if($user->all_comments > 0){
            $user->all_comments = $user->all_comments - 1;
        }

        //Comprobar si soy el dueño del comentario o de la publicación
                                                    //Utilizo la función image del modelo
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            $comment->delete();
            $user->update();
            
        //Redirección
        return redirect()->route('image.detail', ['id' => $comment->image->id])
                        ->with([
                        'message' => 'Comment deleted correctly'
                        ]);
        }else{
        //Redirección
        return redirect()->route('image.detail', ['id' => $comment->image->id])
                        ->with([
                        'message' => 'Comment was not deleted correctly'
                        ]);
        }
    }
}
