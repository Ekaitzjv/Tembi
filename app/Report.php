<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //indicarle la tabla
    protected $table = 'reports';

    //Relación de muchos a uno 
    // El reporte pertenece a 'user_id'
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
    
    //Relación de muchas a uno
    //El reporte pertenece a 'image_id'
    public function image(){
        return $this->belongsTo('App\Image', 'image_id');
    }
}
