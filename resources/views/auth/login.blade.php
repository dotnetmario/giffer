@extends('layouts.auth')

@section('content')
    <!-- title-->
    <h4 class="mt-0">{{ __('auth.login') }}</h4>
    <p class="text-muted mb-4">{{ __('auth.login-instructions') }}</p>

    <!-- form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('auth.email') }}</label>
            <input class="form-control" type="email" id="email" name="email" required="" value="{{ old('email') }}"
                required autofocus placeholder="{{ __('auth.enter-email') }}">
        </div>

        <div class="mb-3">
            <a href="{{ route('password.email') }}"
                class="text-muted float-end"><small>{{ __('auth.forgotten-password-qst') }}</small></a>
            <label for="password" class="form-label">{{ __('auth.password') }}</label>
            <input class="form-control" type="password" required="" id="password" name="password"
                placeholder="{{ __('auth.enter-password') }}">
        </div>


        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">{{ __('auth.remember-me') }}</label>
            </div>
        </div>

        <div class="d-grid mb-0 text-center">
            <button class="btn btn-primary" type="submit">
                <i class="mdi mdi-login"></i> {{ __('auth.login') }}
            </button>
        </div>
    </form>
    <!-- end form-->

    <!-- Footer-->
    <footer class="footer footer-alt">
        <p class="text-muted">
            {{ __('auth.not-registered-qst') }}
            <a href="{{ route('register') }}" class="text-muted ms-1">
                <b>{{ __('auth.register') }}</b>
            </a>
        </p>
    </footer>
@endsection
