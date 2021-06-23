<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
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
            'post_id' => 'integer|required',
            'content' => 'string|required|max:255'
        ]);

        //Recoger datos del formulario
        $user = \Auth::user();
        $post_id = $request->input('post_id');
        $content = $request->input('content');
        
        //Asigno valores a mi nuevo objeto
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->post_id = $post_id;
        $comment->content = $content;
        
        //Guardar en DB
        $comment->save();

        //Redirección
        return redirect()->route('image.detail', ['id' => $post_id])
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
                                                    //Utilizo la función image del modelo
        if($user && ($comment->user_id == $user->id || $comment->post->user_id == $user->id)){
            $comment->delete();
            $user->update();
            
        //Redirección
        return redirect()->route('image.detail', ['id' => $comment->post->id])
                        ->with([
                        'message' => 'Comment deleted correctly'
                        ]);
        }else{
        //Redirección
        return redirect()->route('image.detail', ['id' => $comment->post->id])
                        ->with([
                        'message' => 'Comment was not deleted correctly'
                        ]);
        }
    }
}
