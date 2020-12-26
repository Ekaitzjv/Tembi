<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //indicarle la tabla
    protected $table = 'comments';

    //Relación de muchos a uno / un usuario puede crear muchas publicaciones
    //Significa: El comentario pertenece a 'user_id'
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    //El comentario pertenece a 'image_id'
    public function image(){
        return $this->belongsTo('App\image', 'image_id');
    }
}

