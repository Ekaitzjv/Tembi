@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!--mensaje-->
            @include('includes.message')
            <div class="card pub_image">
                <div class="card-header">
                    <!--Imagen avatar-->
                    @if($image->user->image)
                    <div class="container-avatar avatar-main">
                        <img src="{{ route('user.image',['filename'=>$image->user->image]) }}" />
                    </div>
                    @endif
                    <div class="data-username">
                        <!--Nombre de usuario-->
                        {{$image->user->username}}
                    </div>
                </div>
                <!--Imagen(publicación)-->
                <div class="card-body">
                    <div class="image-container">
                        <img src="{{ route('image.file',['filename' => $image->image_path]) }}" />
                    </div>
                    <!--created at(fecha)-->
                    <div class="created_at-main">
                        <span>{{\FormatTime::LongTimeFilter($image->created_at)}}</span>
                    </div>
                    <!--likes-->
                    <div class="likes">
                        <!--Comprobar si el usuario le dió like a la imagen-->
                        <?php $user_like = false; ?>
                        @foreach($image->likes as $like)
                        @if($like->user->id == Auth::user()->id )
                        <?php $user_like = true; ?>
                        @endif
                        @endforeach

                        @if($user_like)
                        <img src="{{asset('img/like_red.png')}}" data-id="{{$image->id}}" class="btn-like" />
                        @else
                        <img src="{{asset('img/like_empty.png')}}" data-id="{{$image->id}}" class="btn-dislike" />
                        @endif
                        <span class="count_quantity">
                            @if(count($image->likes) != 0)
                                {{count($image->likes)}}
                            @endif
                        </span>
                    </div>
                    <!--comments-->
                    <div class="comments-detail">
                        <p>
                            @if(count($image->comments) != 0)
                                {{count($image->comments)}}
                                @if(count($image->comments) == 1)
                                    comment
                                @else
                                comments
                                @endif
                            @else
                            Add a comment...
                            @endif
                        </p>
                    </div>
                    <!--descripción-->
                    @if(!empty($image->description))
                    <div class="description-box">
                        <span class="description-username">{{$image->user->username}}</span>
                        <p class="description">{{$image->description}}</p>
                    </div>
                    @endif
                    <!--Formulario de comentarios-->
                    <div class="comment-form">
                        <form method="POST" action="{{ route('comment.save') }}">
                            @csrf
                            <button type="submit" class="btn btn-post-comment">Post</button>
                            <input type="hidden" name="image_id" value="{{$image->id}}" />
                            <p>
                                <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"
                                    name="content"></textarea>
                                @if($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                                @endif
                            </p>
                        </form>
                    </div>

                    @foreach($image->comments as $comment)
                    @if(!empty($image->comments))
                    <div class="comments">
                        <span class="username">{{$comment->user->username}}</span>
                        <span class="comment-content">{{$comment->content}}</span>
                        <span class="time-comments">{{\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                        <!--Comprobar que es el usuario del comentario o de la foto-->
                        @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id ==
                        Auth::user()->id))
                        <a class="delete-comment" href="{{route('comment.delete', ['id' => $comment->id]) }}">delete</a>
                        @endif
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection