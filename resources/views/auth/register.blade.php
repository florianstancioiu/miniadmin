<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Register | {{ setting('site-title') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ url('/register') }}">
                {{ setting('site-title') }}
            </a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">{{ __('auth.register_new_membership') }}</p>

                <form action="{{ route('register')}}" method="post">
                    @csrf

                    @error('first_name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="first_name" placeholder="{{ __('auth.first_name') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    @error('last_name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="last_name" placeholder="{{ __('auth.last_name') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="{{ __('auth.email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="{{ __('auth.password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    @error('password_confirmation')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('auth.retype_password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('auth.register') }}</button>
                        </div>
                    </div>

                </form>
                <a href="{{ url('/login') }}" class="text-center">{{ __('auth.i_have_a_membership') }}</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
