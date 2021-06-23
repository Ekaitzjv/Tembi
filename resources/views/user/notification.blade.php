<!--NOTIFICACIÓN-->
@if ($post->all_likes > 0 || count($post->comments) > 0)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!--Notificación-->
            <div class="notification">
                <div class="notification-image">
                    <a href="{{ route('image.detail', ['id' => $post->id])}}">
                        <img src="{{ route('image.file',['filename' => $post->image_path]) }}" />
                    </a>
                </div>
                <div class="notification-container">
                    <div class="notification-like-comment">
                        <!--Ver los likes hechos de cada publicación-->
                        @if (count($post->likes) > 0)
                        <h5>Likes</h5>
                        @foreach($post->likes as $like)
                        <p class="activity-like"><strong>{{ $like->user->username }}</strong> liked your post
                            <span class="time-comments">{{\FormatTime::LongTimeFilter($like->created_at)}}</span></p>
                        @endforeach
                        @endif
                        <!--Ver los comentarios hechos de cada publicación-->
                        @if (count($post->comments) > 0)
                        <h5>Comments</h5>
                        @foreach($post->comments as $comment)
                        <p class="activity-comment"><b>{{ $comment->user->username }}</b>
                            has comment "{{ $comment->content}}" <span
                                class="time-comments">{{\FormatTime::LongTimeFilter($comment->created_at)}}</span></p>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!--Notificación-->
            <div class="notification">
                <div class="notification-image">
                    <a href="{{ route('image.detail', ['id' => $post->id])}}">
                        <img src="{{ route('image.file',['filename' => $post->image_path]) }}" />
                    </a>
                </div>
                <div class="text-center">
                    <h5>No likes or comments yet</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
