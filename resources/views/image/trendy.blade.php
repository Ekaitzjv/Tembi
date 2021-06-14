@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center">
                <span class="h4">TRENDING</span>
            </div>
            <hr>
            <!--Bucle de publicaciones-->
            @each('image.popular_post', $images , 'image')
        </div>
    </div>
</div>
@endsection