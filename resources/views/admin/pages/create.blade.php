@extends('layouts.admin')

@section('title')
    {{ __('pages.create_page') }}
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">{{ __('pages.pages') }}</a></li>
        <li class="breadcrumb-item active">{{ __('general.create') }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-12">
    <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('pages.create_page') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="form-title">{{ __('pages.title') }}</label>
                        <input type="text" name="title" class="form-control" id="form-title" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="form-image">{{ __('pages.image') }}</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="form-image" accept="image/*">
                                <label class="custom-file-label" for="form-image">{{ __('pages.choose_image') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="form-content">{{ __('pages.content') }}</label>
                        <textarea name="content" id="form-content" class="form-control simplemde" cols="30" rows="10" placeholder="Enter content"># Header</textarea>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-create">{{ __('general.create') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
