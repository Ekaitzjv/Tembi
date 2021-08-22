@extends('layouts.app')

@section('content')
<div class="settings">
    <h2>Settings</h2>
    <hr>
    <div class="settings-container">
        <a class="settings-button" href="{{ route('edit') }}">
            Edit profile
            <p>See information about your account and edit your account</p>
        </a>
    </div>
    <div class="settings-container">
        <a class="settings-button" href="{{ route('help') }}">
            More information about privacy
        </a>
    </div>
</div>
@include('layouts.footer')
@endsection

