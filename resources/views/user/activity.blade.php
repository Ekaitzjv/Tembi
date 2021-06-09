@extends('layouts.app')

@section('content')
@if ($user->all_likes > 0 || $user->all_comments > 0)
<!--Bucle de notificaciones-->
@each('user.notification', $user->images , 'image')
@else
<div class="text-center no-activity">
    <h3>No activity yet</h3>
</div>
@endif
@endsection