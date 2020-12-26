<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //indicarle la tabla
    protected $table = 'likes';

    //Relación de muchos a uno 
    // El like pertenece a 'user_id'
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
    
    //Relación de muchos a uno
    //El like pertenece a 'image_id'
    public function image(){
        return $this->belongsTo('App\image', 'image_id');
    }
}
