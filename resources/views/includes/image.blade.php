<!--PUBLICACIÓN-->
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

        <!--BOTONES INFERIORES-->
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
        <div class="comment-btn">
            <a href="{{ route('image.detail', ['id' => $image->id])}}">
                <img src="{{asset('img/comments.png')}}" />
                <span class="count_quantity">
                    @if(count($image->comments) != 0)
                    {{count($image->comments)}}
                    @endif
                </span>
            </a>
        </div>
        <!--descripción-->
        @if(!empty($image->description))
        <div class="description-box">
            <span class="description-username">{{$image->user->username}}</span>
            <p class="description">{{$image->description}}</p>
        </div>
        @endif
    </div>
</div>