@extends('layouts.app')
@section('content')
<!--Mostrar imagen individual-->
<div class="view_image">
    <img src="{{ route('image.file',['filename' => $image->image_path]) }}" />
</div>
@endsection
