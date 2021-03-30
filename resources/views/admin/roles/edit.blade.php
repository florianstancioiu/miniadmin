@extends('layouts.admin')

@section('title')
    {{ __('roles.edit_role') }}
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">{{ __('roles.roles') }}</a></li>
        <li class="breadcrumb-item active">{{ __('general.edit') }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('roles.edit_role') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.roles.update', [ 'role' => $role->id ]) }}" method="POST" enctype="multipart/form-data">
                @method("PUT")
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="form-title">{{ __('roles.title') }}</label>
                        <input type="text" name="title" class="form-control" id="form-title" placeholder="{{ __('roles.enter_title') }}" value="{{ $role->title }}">
                    </div>
                    <div class="form-group">
                        <label for="form-slug">{{ __('roles.slug') }}</label>
                        <input type="text" name="slug" class="form-control" id="form-slug" placeholder="{{ __('roles.enter_slug') }}" value="{{ $role->slug }}">
                    </div>

                    @foreach($permissions as $permission)
                        <div class="form-group">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="form-permission-{{$permission->slug}}"
                            @if(in_array($permission->id, $selected_permissions)) checked @endif>
                            <label for="form-permission-{{$permission->slug}}">{{ $permission->title }}</label>
                        </div>
                    @endforeach
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-edit">{{ __('general.edit') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
