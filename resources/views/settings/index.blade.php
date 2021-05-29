@extends('layouts.app')

@section('content')
<div class="">
    <h2>Settings</h2>
    <div class="">
        <a class="" href="{{ route('edit') }}">Edit profile</a>
        <p>See information about your account and edit your account</p>
    </div>
    <div class="">
        <a class="" href="{{ route('help') }}">More information about privacy</a>
    </div>
</div>
@endsection

@extends('layouts.footer')