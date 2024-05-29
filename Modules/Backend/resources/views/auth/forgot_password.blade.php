@extends('backend::layouts.auth')
@section('content')
    <div class="auth-form-light text-left p-5">
        @if ($logo = get_config('logo'))
            <div class="brand-logo">
                <img src="{{ upload_url(get_config('logo')) }}" alt="{{ get_config('title', 'Inter Test') }}">
            </div>
        @else
            <div class="brand-logo">
                <h2>{{ get_config('title', 'Inter Test') }}</h2>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (auth()->user())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Warning!</strong> You are already logged in.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        <h4>{{ trans('backend::auth.hello_lets_started', ['app' => get_config('title', 'Inter Test')]) }}</h4>
        <h6 class="font-weight-light">Sign in to continue.</h6>
        <form class="pt-3 form-ajax-handle" action="{{ route('admin.forgot-password') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="email" name="email" class="form-control form-control-lg" id="emailField"
                    placeholder="Email">
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn"
                    data-loading-text="Loading...">
                    Forgot Password
                </button>
            </div>
            <div class="my-2 d-flex justify-content-between align-items-center">
                @if (get_config('user_keep_signed_in', true))
                    <div class="form-check">
                        <label class="form-check-label text-muted">
                            <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                    </div>
                @endif
                @if (get_config('user_forgot_password', true))
                    <a href="" class="auth-link text-black">Forgot password?</a>
                @endif
            </div>
            <div class="mb-2">
                <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="mdi mdi-facebook mr-2"></i>Connect using facebook </button>
            </div>
            @if (get_config('user_registration'))
                <div class="text-center mt-4 font-weight-light"> Don't have an account? <a
                        href="{{ route('admin.register') }}" class="text-primary">Create</a>
                </div>
            @endif
        </form>
    </div>
@endsection
