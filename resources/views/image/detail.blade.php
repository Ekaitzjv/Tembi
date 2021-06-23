@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!--mensaje-->
            @include('includes.message')
            <div class="card pub_image">
                <div class="card-header">
                    @if(Auth::user() && Auth::user()->id == $post->user->id)
                    <!--3 puntos desplegables-->
                    <div class="nav-item dropdown dots">
                        <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <img class="avatar" src="{{ asset('img/dots.png')}}" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('image.edit', ['id' => $post->id])}}">
                                Edit
                            </a>
                            <a class="dropdown-item delete-publication"
                                href="{{ route('image.delete', ['id' => $post->id]) }}">
                                Delete
                            </a>
                        </div>
                    </div>
                    @endif
                    <!--Imagen avatar-->
                    @if($post->user->image)
                    <div class="container-avatar avatar-main">
                        <a href=" {{ route('profile', ['id' => $post->user->id])}}">
                            <img src="{{ route('user.image',['filename'=>$post->user->image]) }}" />
                        </a>
                    </div>
                    @else
                    <div class="container-avatar avatar-main">
                        <a href=" {{ route('profile', ['id' => $post->user->id])}}">
                            <img class="avatar" src="{{ asset('img/default-avatar.jpg')}}" />
                        </a>
                    </div>
                    @endif
                    <div class="data-username">
                        <!--Nombre de usuario-->
                        <a href="{{ route('profile', ['id' => $post->user->id])}}">{{$post->user->username}}</a>
                    </div>
                </div>
                <!--Imagen(publicación)-->
                <div class="card-body">
                    <div class="image-container">
                        <img src="{{ route('image.file',['filename' => $post->image_path]) }}" />
                    </div>
                    <script>
                    function report() {
                        confirm("Are you sure to report this post?");
                    }
                    </script>
                    <!--BOTONES INFERIORES-->
                    @if (Auth::user()->id != $post->user_id)
                    <div class="report-image">
                        <a onclick="report()" href="{{route('report', ['post_id' => $post->id]) }}">
                            <img src="{{asset('img/report.png')}}" />
                        </a>
                    </div>
                    @endif
                    <!--created at(fecha)-->
                    <div class="created_at-main">
                        <span>{{\FormatTime::LongTimeFilter($post->created_at)}}</span>
                    </div>
                    <!--likes-->
                    <div class="likes">
                        <!--Comprobar si el usuario le dió like a la imagen-->
                        <?php $user_like = false; ?>
                        @foreach($post->likes as $like)
                        @if($like->user->id == Auth::user()->id )
                        <?php $user_like = true; ?>
                        @endif
                        @endforeach

                        @if($user_like)
                        <img src="{{asset('img/like_red.png')}}" data-id="{{$post->id}}" class="btn-like" />
                        @else
                        <img src="{{asset('img/like_empty.png')}}" data-id="{{$post->id}}" class="btn-dislike" />
                        @endif
                        <span class="count_quantity">
                            @if(count($post->likes) != 0)
                            {{count($post->likes)}}
                            @endif
                        </span>
                    </div>
                    <!--comments-->
                    <div class="comments-detail">
                        <p>
                            @if(count($post->comments) > 0)
                            {{count($post->comments)}}
                            @if(count($post->comments) == 1)
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
                    @if(!empty($post->description))
                    <div class="description-box">
                        <span class="description-username">{{$post->user->username}}</span>
                        <p class="description">{{$post->description}}</p>
                    </div>
                    @endif
                    <!--Formulario de comentarios-->
                    <div class="comment-form">
                        <form method="POST" action="{{ route('comment.save') }}">
                            @csrf
                            <button type="submit" class="btn btn-post-comment">Post</button>
                            <input type="hidden" name="post_id" value="{{$post->id}}" />
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

                    @foreach($post->comments as $comment)
                    @if(!empty($post->comments))
                    <div class="comments">
                        <span class="username">{{$comment->user->username}}</span>
                        <span class="comment-content">{{$comment->content}}</span>
                        <span class="time-comments">{{\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                        <!--Comprobar que es el usuario del comentario o de la foto-->
                        @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->post->user_id ==
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