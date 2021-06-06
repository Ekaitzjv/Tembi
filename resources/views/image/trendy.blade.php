@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <center><h4>TRENDING</h4></center>
            <hr>
            <!--Bucle de publicaciones-->
            @each('image.popular_post', $images , 'image')
        </div>
    </div>
</div>
@endsection