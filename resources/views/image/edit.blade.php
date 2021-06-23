@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit image</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('image.update') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="post_id" value="{{$post->id}}" />

                        <div class="form-group row">
                            <label for="image_path" class="col-md-3 col-form-label text-md-right">Image</label>
                            <div class="col-md-7">
                                @if($image->image_path)
                                <div class="edit-image">
                                    <img src="{{ route('image.file',['filename' => $post->image_path]) }}"/>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
                            <div class="col-md-7">
                                <textarea id="description" name="description"
                                    class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                    >{{$image->description}}</textarea>

                                @if($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-6 offset-md-3">
                                <input type="submit" class="btn btn-primary" value="Update image">
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection