<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //indicarle la tabla
    protected $table = 'comments';

    //Relación de muchos a uno / un usuario puede crear muchas publicaciones
    public function user(){
        //Significa: El comentario pertenece a este 'user_id'
        return $this->belongsTo('App\User', 'user_id');
    }

    public function image(){
        //El comentario pertenece a esta 'image_id'
        return $this->belongsTo('App\image', 'image_id');
    }
}

