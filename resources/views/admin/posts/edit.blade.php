@extends('layouts.admin')

@section('title')
    {{ __('posts.edit_post') }}
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">{{ __('posts.posts') }}</a></li>
        <li class="breadcrumb-item active">{{ __('general.edit') }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('posts.edit_post') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.posts.update', [ 'id' => $post->id ]) }}" method="POST" enctype="multipart/form-data">
                @method("PUT")
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="form-title">{{ __('posts.title') }}</label>
                        <input type="text" name="title" class="form-control" id="form-title" placeholder="{{ __('posts.enter_title') }}" value="{{ $post->title }}">
                    </div>
                    <div class="form-group">
                        <label for="form-image">{{ __('posts.image') }}</label>
                        @if ($post->image)
                            <img src="{{ $post->image_url }}" alt="" class="form-image">
                        @endif
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="form-image" name="image" accept="image/*">
                                <label class="custom-file-label" for="form-image">{{ __('posts.choose_image') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="form-content">{{ __('posts.content') }}</label>
                        <textarea name="content" id="form-content" class="form-control" cols="30" rows="10" placeholder="{{ __('posts.enter_content') }}">{{ $post->content }}</textarea>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('general.edit') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
