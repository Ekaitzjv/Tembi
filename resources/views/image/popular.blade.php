@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1>Popular of the week</h1>
        <div class="col-md-8">
            <!--Bucle de publicaciones-->
            @each('image.popular_post', $images, 'image')
        </div>
    </div>
</div>
@endsection