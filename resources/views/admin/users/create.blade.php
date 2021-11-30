@extends('layouts.admin')

@section('title')
    {{ __('users.create_user') }}
@endsection

@section('content')
    <div class="col-md-10 col-lg-8">
        <div class="card card-primary">
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
                        <label for="form-role">{{ __('users.role') }}</label>
                        <select id="form-role" class="form-control" name="role_id">
                            <option value="" selected disabled>{{ __('users.select_role') }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="form-password">{{ __('users.password') }}</label>
                        <input type="password" name="password" class="form-control" id="form-password" placeholder="{{ __('users.enter_password') }}">
                    </div>

                    <div class="form-group">
                        <label for="form-confirm-password">{{ __('users.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" id="form-confirm-password" placeholder="{{ __('users.enter_confirm_password') }}">
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-create">{{ __('general.create') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
