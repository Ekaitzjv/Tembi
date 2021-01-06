@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="data-user-profile">
                <!--Imagen avatar-->
                @if($user->image)
                <div class="avatar-profile">
                    <img src="{{ route('user.image',['filename'=>$user->image]) }}" />
                </div>
                @else
                <div class="avatar-profile">
                    <img src="{{ asset('img/default-avatar.jpg')}}" />
                </div>
                @endif
                <div class="data-user">
                    <h5 class="username-profile">{{$user->username}}</h5>
                    <h5 class="name-surname-profile">{{$user->name.' '.$user->surname}}</h5>
                </div>
                @if($user->description)
                <div class="container description-profile-box">
                    <p class="description-profile">{{$user->description}}</p>
                </div>
                @endif
                <div class="clearfix"></div>
                <hr>
            </div>

            @if(count($user->images) == 0)
            <div class="profile-empty">
                <center>
                    <h3>No Posts Yet</h3>
                </center>
            </div>
            @else
            <!--Bucle de publicaciones-->
            @foreach($user->images as $image)
            @include('includes.image', ['image'=>$image])
            @endforeach
            @endif

        </div>
    </div>
</div>
@endsection