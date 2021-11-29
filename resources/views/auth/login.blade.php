<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in | {{ setting('site-title') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('admin.dashboard') }}">
                {{ setting('site-title') }}
            </a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('auth.sign_in_to_start_session') }}</p>

                <form action="{{ route('login') }}" method="post">
                    @csrf

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

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    {{ __('auth.remember_me') }}
                                </label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('auth.sign_in') }}</button>
                        </div>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="{{ route('password.request') }}">{{ __('auth.i_forgot_my_password') }}</a>
                </p>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
