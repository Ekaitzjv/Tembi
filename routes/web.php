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

//Generales
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/main', 'HelpController@index')->name('main');

//Configuración
Route::get('/settings', 'SettingsController@index')->name('settings');

//Ayuda
Route::get('/help', 'HelpController@help')->name('help');
Route::get('/privacy', 'HelpController@privacy')->name('privacy');
Route::get('/cookies', 'HelpController@cookies')->name('cookies');

//Administrador
Route::get('/admin', 'UserController@admin')->name('admin');
Route::get('/reports', 'UserController@reports')->name('reports');
Route::get('/report/user/delete/{id}', 'UserController@ReportUserDelete')->name('ReportUserDelete');
Route::get('/report/post/delete/{id}', 'UserController@ReportPostDelete')->name('ReportPostDelete');
Route::get('/report/post/cancel/{id}', 'UserController@ReportCancel')->name('ReportCancel');

//Usuario
Route::get('/edit', 'UserController@edit')->name('edit');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/image/{filename}', 'UserController@getImage')->name('user.image');
Route::get('/profile/{id}', 'UserController@profile')->name('profile');
Route::get('/people/{search?}', 'UserController@index')->name('user.index');
Route::get('/activity', 'UserController@activity')->name('activity');
Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete');

//Imagen
Route::get('/create', 'PostController@create')->name('image.create');
Route::post('/image/save', 'PostController@save')->name('image.save');
Route::get('/image/file/{filename}', 'PostController@getImage')->name('image.file');
Route::get('/image/{id}', 'PostController@detail')->name('image.detail');
Route::get('/view/{id}', 'PostController@view')->name('image.view');
Route::get('/image/delete/{id}', 'PostController@delete')->name('image.delete');
Route::get('/image/edit/{id}', 'PostController@edit')->name('image.edit');
Route::post('/image/update', 'PostController@update')->name('image.update');
Route::get('/trendy', 'PostController@trendy')->name('trendy');
Route::get('/report/{post_id}', 'PostController@report')->name('report');


//Comentarios
Route::post('/comment/save', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

//Likes
Route::get('/like/{post_id}', 'LikeController@like')->name('like.like');
Route::get('/dislike/{post_id}', 'LikeController@dislike')->name('like.dislike');
Route::get('/likes', 'LikeController@index')->name('likes');
