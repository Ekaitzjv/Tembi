@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>People</h3>
            <form method="GET" action="{{ route('user.index') }}"  id="browser">
                <div class="row browser">
                    <div class="form-group col browser">
                        <input type="text" id="search" class="form-control field-browser"/>
                    </div>
                    <div class="form-group col">
                        <input type="submit" value="Search" class="btn btn-search" />
                    </div>
                </div>
            </form>
            <hr>
            <!--Bucle de publicaciones-->
            @foreach($users as $user)
            <a href=" {{ route('profile', ['id' => $user->id])}}">
                <div class="data-user-profile profile-people">
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
            </a>
            @endforeach

            <!--PAGINACIÓN-->
            <div class="clearfix"></div>
            {{$users->links()}}
        </div>
    </div>
</div>
@endsection