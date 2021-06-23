<!--PUBLICACIÓN-->
<div class="card pub_image">
    <div class="card-header">
        <!--TOP number-->
        <div class="hashtag">
            <h5>#{{$key+1}}</h5>
        </div>
        <!--Imagen avatar-->
        <div class="container-avatar avatar-main">
            <a href=" {{ route('profile', ['id' => $post->user->id])}}">
                @if($post->user->image)
                <img src="{{ route('user.image',['filename'=>$post->user->image]) }}" />
                @else
                <img class="avatar" src="{{ asset('img/default-avatar.jpg')}}" />
                @endif
            </a>
        </div>

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

        <!--BOTONES INFERIORES-->
        <!--Ver imagen-->
        <div class="view-image">
            <a href="{{ route('image.view', ['id' => $post->id])}}">
                <img src="{{asset('img/view.png')}}" />
            </a>
        </div>

        <!--created at(fecha)-->
        <div class="created_at-main">
            <p>{{\FormatTime::LongTimeFilter($post->created_at)}}</p>
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
                @if(count($post->likes) > 0)
                {{count($post->likes)}}
                @endif
            </span>
        </div>
        <!--comments-->
        <div class="comment-btn">
            <a href="{{ route('image.detail', ['id' => $post->id])}}">
                <img src="{{asset('img/comments.png')}}" />
                <span class="count_quantity">
                    @if(count($post->comments) > 0)
                    {{count($post->comments)}}
                    @endif
                </span>
            </a>
        </div>
        <!--descripción-->
        @if(!empty($post->description))
        <div class="description-box">
            <span class="description-username">{{$post->user->username}}</span>
            <p class="description">{{$post->description}}</p>
        </div>
        @endif
    </div>
</div>