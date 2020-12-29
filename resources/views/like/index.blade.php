@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>Favorite pictures</h3>
            <hr>
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