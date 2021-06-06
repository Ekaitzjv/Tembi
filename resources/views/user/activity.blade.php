@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($user->images) == 0)
            <div class="profile-empty">
                <center>
                    <h3>No activity Yet</h3>
                </center>
            </div>
            @else
            <!--Bucle de publicaciones-->
            @each('user.notification', $user->images , 'image')
            @endif

        </div>
    </div>
</div>
@endsection