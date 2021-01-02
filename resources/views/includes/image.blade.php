<!--PUBLICACIÓN-->
<div class="card pub_image">
    <div class="card-header">
        <!--3 puntos desplegables-->
        <div class="nav-item dropdown dots">
            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown">
                <img class="avatar" src="{{ asset('img/dots.png')}}" />
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('profile', ['id' => Auth::user()->id])}}">
                    My Profile
                </a>

                <a class="dropdown-item" href="{{ route('edit') }}">
                    Edit profile
                </a>
            </div>
        </div>
        <!--Imagen avatar-->
        @if($image->user->image)
        <div class="container-avatar avatar-main">
            <a href=" {{ route('profile', ['id' => $image->user->id])}}">
                <img src="{{ route('user.image',['filename'=>$image->user->image]) }}" />
            </a>
        </div>
        @else
        <div class="container-avatar avatar-main">
            <a href=" {{ route('profile', ['id' => $image->user->id])}}">
                <img class="avatar" src="{{ asset('img/default-avatar.jpg')}}" />
            </a>
        </div>
        @endif
        <div class="data-username">
            <!--Nombre de usuario-->
            <a href="{{ route('profile', ['id' => $image->user->id])}}">{{$image->user->username}}</a>
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
            <a href="{{ route('image.view', ['id' => $image->id])}}">
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