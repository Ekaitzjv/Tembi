@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--mensaje-->
            @include('includes.message')

            <!--Bucle de imagenes principales-->
            @foreach($images as $image)
            <div class="card pub_image">
                <div class="card-header">
                    <!--Imagen avatar-->

                    @if($image->user->image)
                    <div class="container-avatar avatar-main">
                        <img src="{{ route('user.image',['filename'=>$image->user->image]) }}" />
                    </div>
                    @endif
                    <div class="data-user">
                        <!--Nombre de usuario-->
                        {{$image->user->username}}
                    </div>
                </div>
                <div class="card-body">

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection