@extends('layouts.admin')

@section('title')
    {{ __('users.edit_user') }}
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('users.users') }}</a></li>
        <li class="breadcrumb-item active">{{ __('general.edit') }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-12">
    <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('users.edit_user') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.users.update', ['user'=> $user->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">

                    <input type="hidden" name="id" value="{{ $user->id }}"/>

                    <div class="form-group">
                        <label for="form-image">{{ __('users.image') }}</label>
                        @if ($user->image)
                            <img src="{{ $user->image_url }}" alt="" class="form-image">
                        @endif
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="form-image" accept="image/*">
                                <label class="custom-file-label" for="form-image">{{ __('users.choose_image') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="form-first-name">{{ __('users.first_name') }}</label>
                        <input type="text" name="first_name" class="form-control" id="form-first-name" placeholder="{{ __('users.enter_first_name') }}" value="{{ $user->first_name }}">
                    </div>

                    <div class="form-group">
                        <label for="form-last-name">{{ __('users.last_name') }}</label>
                        <input type="text" name="last_name" class="form-control" id="form-last-name" placeholder="{{ __('users.enter_last_name') }}" value="{{ $user->last_name }}">
                    </div>

                    <div class="form-group">
                        <label for="form-email">{{ __('users.email') }}</label>
                        <input type="text" name="email" class="form-control" id="form-email" placeholder="{{ __('users.enter_email') }}" value="{{ $user->email }}">
                    </div>

                    <div class="form-group">
                        <label for="form-role">{{ __('users.role') }}</label>
                        <select id="form-role" class="form-control" name="role_id">
                            <option value="" disabled>{{ __('users.select_role') }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if($role->id === $user->role_id) selected @endif>{{ $role->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-edit-user">{{ __('users.edit_user') }}</button>
                </div>
            </form>
        </div>

        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">{{ __('users.edit_password') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.users.update-password', ['user'=> $user->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">

                    <input type="hidden" name="id" value="{{ $user->id }}"/>

                    <div class="form-group">
                        <label for="form-password">{{ __('users.new_password') }}</label>
                        <input type="password" name="password" class="form-control" id="form-password" placeholder="{{ __('users.enter_new_password') }}">
                    </div>

                    <div class="form-group">
                        <label for="form-confirm-password">{{ __('users.confirm_new_password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" id="form-confirm-password" placeholder="{{ __('users.enter_confirm_new_password') }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-edit-password">{{ __('users.edit_password') }}</button>
                </div>
            </form>
        </div>

    </div>
@endsection
