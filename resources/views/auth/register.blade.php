@extends('layouts.auth')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- title-->
    <h4 class="mt-0">{{ __('auth.register') }}</h4>
    <p class="text-muted mb-4">{{ __('auth.register-instructions') }}</p>

    <!-- form -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('auth.name') }}</label>
            <input class="form-control" type="text" id="name" name="name" required=""
                value="{{ old('name') }}" required autofocus placeholder="{{ __('auth.enter-name') }}">
        </div>


        <div class="mb-3">
            <label for="username" class="form-label">{{ __('auth.username') }}</label>
            <input class="form-control" type="text" id="username" name="username" required=""
                value="{{ old('username') }}" required placeholder="{{ __('auth.enter-username') }}">
        </div>


        <div class="mb-3">
            <label for="email" class="form-label">{{ __('auth.email') }}</label>
            <input class="form-control" type="email" id="email" name="email" required=""
                value="{{ old('email') }}" required placeholder="{{ __('auth.enter-email') }}">
        </div>


        <div class="mb-3">
            <label for="password" class="form-label">{{ __('auth.password') }}</label>
            <input class="form-control" type="password" required="" id="password" name="password"
                placeholder="{{ __('auth.enter-password') }}">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('auth.confirm-password') }}</label>
            <input class="form-control" type="password" required="" id="password_confirmation"
                name="password_confirmation" placeholder="{{ __('auth.econfirm-password') }}">
        </div>

        <div class="d-grid mb-0 text-center">
            <button class="btn btn-primary" type="submit">
                <i class="mdi mdi-login"></i> {{ __('auth.register') }}
            </button>
        </div>
    </form>
    <!-- end form-->

    <!-- Footer-->
    <footer class="footer footer-alt">
        <p class="text-muted">
            {{ __('auth.already-registered-qst') }}
            <a href="{{ route('login') }}" class="text-muted ms-1">
                <b>{{ __('auth.login') }}</b>
            </a>
        </p>
    </footer>
@endsection
