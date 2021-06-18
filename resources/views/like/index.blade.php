@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--Comprobar si hay imagenes favoritas-->
            @if(count($likes))
                <div class="text-center">
                    <span class="h4">FAVORITE PICTURES</span>
                </div>
                <hr>
            @else
                <div class="text-center">
                    <span class="h4">You don't have favourite pictures</span>
                    <p class="inform-activity">You have to like a post to make it appear here!</p>
                </div>
            @endif
                <!--Bucle de publicaciones-->
                    @foreach($likes as $like)
                        <!--Listar solo las imagenes con LIKE-->
                        @include('includes.image',['image'=>$like->image])
                    @endforeach

            <!--PAGINACIÓN-->
            <div class="clearfix"></div>
            {{$likes->links()}}
        </div>
    </div>
</div>
@endsection
