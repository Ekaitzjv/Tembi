<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//use App\Image;


Route::get('/', function () {

/*
    //para sacar todas las imagenes de la db
    $images = Image::all();
    foreach($images as $image){
        echo $image->image_path."<br/>";
        echo $image->description."<br/>";
        echo $image->user->name.' '.$image->user->surname;

        //que muestre comentarios si los hay
        if(count($image->comments) >= 1 ){
            echo '<h4>Comentarios:</h4>';
            foreach($image->comments as $comment){
                echo $comment->user->name.' '.$comment->user->surname.': ';
                echo $comment->content.'<br/>';
            }
        }
        //sacar los likes
        echo 'Likes: '.count($image->likes);
        echo "<hr/>";
    }

    die();
    */
    return view('welcome');
});

//comandos en la consola para poder hacer esto:
//composer require laravel/ui 
//php artisan ui vue --auth 
//npm install && npm run dev

//Login
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/edit', 'UserController@edit')->name('edit');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/image/{filename}', 'UserController@getImage')->name('user.image');
Route::get('/create', 'ImageController@create')->name('image.create');
Route::post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');
Route::get('/image/{id}', 'ImageController@detail')->name('image.detail');
Route::post('/comment/save', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');



