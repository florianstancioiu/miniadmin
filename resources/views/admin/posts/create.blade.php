@extends('layouts.admin')

@section('title')
    {{ __('posts.create_post') }}
@endsection

@section('content')
    <div class="col-md-10 col-lg-8">
        <div class="card card-primary">
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
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-create">{{ __('general.create') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
