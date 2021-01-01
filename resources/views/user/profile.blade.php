@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="data-username-profile">
                <!--Imagen avatar-->
                    @if($user->image)
                    <div class="container-avatar avatar-profile">
                        <a href=" {{$user->username}}">
                            <img src="{{ route('user.image',['filename'=>$user->image]) }}" />
                        </a>
                    </div>
                    @endif
                <div class="data-user">
                    <h2 class="username-profile">{{$user->username}}</h2>
                    <h2 class="name-surname-profile">{{$user->name.' '.$user->surname}}</h2>
                    <p class="description-profile">{{$user->description}}</p>
                </div>
            </div>

            <!--Bucle de publicaciones-->
            @foreach($user->images as $image)
            @include('includes.image', ['image'=>$image])
            @endforeach

        </div>
    </div>
</div>
@endsection