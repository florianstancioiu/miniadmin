@extends('layouts.admin')

@section('title')
    {{ __('posts.create_post') }}
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">{{ __('posts.posts') }}</a></li>
        <li class="breadcrumb-item active">{{ __('general.create') }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-12">
    <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('posts.create_post') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="form-title">{{ __('posts.title') }}</label>
                        <input type="text" name="title" class="form-control" id="form-title" placeholder="{{ __('posts.enter_title') }}">
                    </div>
                    <div class="form-group">
                        <label for="form-image">{{ __('posts.image') }}</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="form-image" accept="image/*">
                                <label class="custom-file-label" for="form-image">{{ __('posts.choose_image') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="form-content">{{ __('posts.content') }}</label>
                        <textarea name="content" id="form-content" class="form-control" cols="30" rows="10" placeholder="{{ __('posts.enter_content') }}"></textarea>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('general.create') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
