@extends('layouts.admin')

@section('title')
    {{ __('permissions.create_permission') }}
@endsection

@section('content')
    <div class="col-md-10 col-lg-8 offset-lg-2">
        <div class="card card-primary">
            <form role="form" action="{{ route('admin.permissions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="form-title">{{ __('permissions.title') }}</label>
                        <input type="text" name="title" class="form-control" id="form-title" placeholder="{{ __('permissions.enter_title') }}">
                    </div>
                    <div class="form-group">
                        <label for="form-slug">{{ __('permissions.slug') }}</label>
                        <input type="text" name="slug" class="form-control" id="form-slug" placeholder="{{ __('permissions.enter_slug') }}">
                    </div>
                    <div class="form-group">
                        <label for="form-group">{{ __('permissions.group') }}</label>
                        <input type="text" name="group" class="form-control" id="form-group" placeholder="{{ __('permissions.enter_group') }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-create">{{ __('general.create') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
