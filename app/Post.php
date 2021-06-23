<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //indicarle la tabla
    protected $table = 'posts';

    //Relación de muchos a uno / un usuario puede crear muchas publicaciones
    //La imagen pertenece a 'user_id'
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    //Relación One To Many / de uno a muchos
    //una imagen puede tener muchos comentarios
    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    //Relación One To Many
    //Una imagen puede tener muchos likes
    public function likes(){
        return $this->hasMany('App\Like');
    }
}
