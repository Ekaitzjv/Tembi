@extends('layouts.app')

@section('content')

@if (count($user->posts) > 0)
    <div class="text-center">
        <span class="h4">ACTIVITY</span>
    </div>

    <!--Bucle de notificaciones-->
    @each('user.notification', $user->posts , 'image')

@else
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="notification">
                <div class="text-center no-activity">
                    <span class="h4">No likes or comments yet</span>
                    <p class="inform-activity">Here you will see the notifications of your account</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
