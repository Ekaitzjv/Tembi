@if(Auth::user()->image)
<div class="container-avatar">
    <img src="{{ route('user.image',['filename'=>Auth::user()->image]) }}" class="avatar" />
</div>
@endif