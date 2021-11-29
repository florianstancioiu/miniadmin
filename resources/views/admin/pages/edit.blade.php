@extends('layouts.admin')

@section('title')
    {{ __('pages.edit_page') }}
@endsection

@section('content')
    <div class="col-md-10 col-lg-8">
        <div class="card card-primary">
            <form role="form" action="{{ route('admin.pages.update', [ 'page' => $page->id ]) }}" method="POST" enctype="multipart/form-data">
                @method("PUT")
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="form-title">{{ __('general.title') }}</label>
                        <input type="text" name="title" class="form-control" id="form-title" placeholder="{{ __('pages.enter_title') }}" value="{{ $page->title }}">
                    </div>
                    <div class="form-group">
                        <label for="form-image">{{ __('general.image') }}</label>
                        @if ($page->image)
                            <img src="{{ $page->image_url }}" alt="" class="form-image">
                        @endif
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="form-image" name="image" accept="image/*">
                                <label class="custom-file-label" for="form-image">{{ __('pages.choose_image') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="form-content">{{ __('general.content') }}</label>
                        <textarea name="content" id="form-content" class="form-control simplemde" cols="30" rows="10" placeholder="{{ __('pages.enter_content') }}">{{ $page->content }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-edit">{{ __('general.edit') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
