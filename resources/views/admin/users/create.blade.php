@extends('layouts.admin')

@section('title')
    {{ __('users.create_user') }}
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('users.users') }}</a></li>
        <li class="breadcrumb-item active">{{ __('general.create') }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-12">
    <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('users.create_user') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label for="form-image">{{ __('users.image') }}</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="form-image" accept="image/*">
                                <label class="custom-file-label" for="form-image">{{ __('users.choose_image') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="form-first-name">{{ __('users.first_name') }}</label>
                        <input type="text" name="first_name" class="form-control" id="form-first-name" placeholder="{{ __('users.enter_first_name') }}">
                    </div>

                    <div class="form-group">
                        <label for="form-last-name">{{ __('users.last_name') }}</label>
                        <input type="text" name="last_name" class="form-control" id="form-last-name" placeholder="{{ __('users.enter_last_name') }}">
                    </div>

                    <div class="form-group">
                        <label for="form-email">{{ __('users.email') }}</label>
                        <input type="text" name="email" class="form-control" id="form-email" placeholder="{{ __('users.enter_email') }}">
                    </div>

                    <div class="form-group">
                        <label for="form-password">{{ __('users.password') }}</label>
                        <input type="password" name="password" class="form-control" id="form-password" placeholder="{{ __('users.enter_password') }}">
                    </div>

                    <div class="form-group">
                        <label for="form-confirm-password">{{ __('users.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" id="form-confirm-password" placeholder="{{ __('users.enter_confirm_password') }}">
                    </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-create">{{ __('general.create') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
