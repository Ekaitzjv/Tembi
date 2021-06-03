@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--Comprobar si hay imagenes favoritas-->
            @if(count($likes))
                <h3>Saved pictures</h3>
                <hr>
            @else
                <center><h4>You don't have favourite pictures</h4></center>
            @endif
                <!--Bucle de publicaciones-->
                    @foreach($likes as $like)
                        <!--Listar solo las imagenes con LIKE-->
                        @include('includes.image', ['image'=>$like->image])
                    @endforeach
            
            <!--PAGINACIÓN-->
            <div class="clearfix"></div>
            {{$likes->links()}}
        </div>
    </div>
</div>
@endsection
