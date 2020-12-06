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
                <!--Imagen(publicación)-->
                <div class="card-body">
                    <div class="image-container">
                        <img src="{{ route('image.file',['filename' => $image->image_path]) }}" />
                    </div>
                    <!--Ver imagen-->
                    <div class="view-image">
                        <a href="">
                            <img src="{{asset('img/view.png')}}" />
                        </a>
                    </div>
                    <!--created at(fecha)-->
                    <div class="created_at-main">
                        <p>{{\FormatTime::LongTimeFilter($image->created_at)}}</p>
                    </div>
                    <!--likes-->
                    <div class="likes">
                        <img src="{{asset('img/like_empty.png')}}" />
                    </div>
                    <!--comments-->
                    <div class="comment-btn">
                        <a href="{{ route('image.detail', ['id' => $image->id])}}">
                            <img src="{{asset('img/comments.png')}}" />
                            @if(!empty(count($image->comments)))
                            ({{count($image->comments)}})
                            @endif
                        </a>
                    </div>
                    <!--descripción-->
                    @if(!empty($image->description))
                    <div class="description-box">
                        <span class="username">{{$image->user->username}}</span>
                        <p class="description">{{$image->description}}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach

            <!--PAGINACIÓN-->
            <div class="clearfix"></div>
            {{$images->links()}}
        </div>
    </div>
</div>
@endsection