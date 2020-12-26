<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

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
        
        //Guardar en DB
        $comment->save();

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

        //Comprobar si soy el dueño del comentario o de la publicación
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            $comment->delete();

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
