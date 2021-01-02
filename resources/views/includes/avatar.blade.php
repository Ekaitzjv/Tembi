@if(Auth::user()->image)
<div class="container-avatar">
    <img class="avatar" src="{{ route('user.image',['filename'=>Auth::user()->image]) }}" />
</div>
@else
<div class="container-avatar">
    <img class="avatar" src="{{ asset('img/default-avatar.jpg')}}" />
</div>
@endif