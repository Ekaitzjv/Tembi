<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //indicarle la tabla
    protected $table = 'images';

    //Relación One To Many / de uno a muchos
    //un modelo va a poder tener muchos comentarios
    public function comments(){
        return $this->hasMany('App\Comment');
    }

    //Relación One To Many
    public function likes(){
        return $this->hasMany('App\Like');
    }

    //Relación de muchos a uno / un usuario puede crear muchas publicaciones
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
