@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--mensaje-->
            @include('includes.message')
            
             <!--Bucle de publicaciones-->
             @each('includes.image', $images , 'image')
            <!--PAGINACIÓN-->
            <div class="clearfix"></div>
            {{$images->links()}}
        </div>
    </div>
</div>
@endsection