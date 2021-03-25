@extends('layouts.admin')

@section('title')
    {{ __('permissions.edit_permission') }}
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">{{ __('permissions.permissions') }}</a></li>
        <li class="breadcrumb-item active">{{ __('general.edit') }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('permissions.edit_permission') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.permissions.update', [ 'permission' => $permission->id ]) }}" method="POST" enctype="multipart/form-data">
                @method("PUT")
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="form-title">{{ __('permissions.title') }}</label>
                        <input type="text" name="title" class="form-control" id="form-title" placeholder="{{ __('permissions.enter_title') }}" value="{{ $permission->title }}">
                    </div>
                    <div class="form-group">
                        <label for="form-slug">{{ __('permissions.slug') }}</label>
                        <input type="text" name="slug" class="form-control" id="form-slug" placeholder="{{ __('permissions.enter_slug') }}" value="{{ $permission->slug }}">
                    </div>
                    <div class="form-group">
                        <label for="form-group">{{ __('permissions.group') }}</label>
                        <input type="text" name="group" class="form-control" id="form-group" placeholder="{{ __('permissions.enter_group') }}" value="{{ $permission->group }}">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-edit">{{ __('general.edit') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
