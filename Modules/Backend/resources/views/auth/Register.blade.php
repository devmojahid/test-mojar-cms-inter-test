@extends('backend::layouts.auth')
@section('content')
    <div class="auth-form-light text-left p-5">
        <div class="brand-logo">
            <img src="../../assets/images/logo.svg">
        </div>
        <h4>Hello! let's get started</h4>
        <h6 class="font-weight-light">Sign UP to continue.</h6>
        <form class="pt-3 form-ajax-handle" action="{{ route('admin.register') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="name" class="form-control form-control-lg" id="nameField"
                    placeholder="Name Hear">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control form-control-lg" id="emailField"
                    placeholder="Username">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control form-control-lg" id="passwordField"
                    placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation" class="form-control form-control-lg"
                    id="passwordFieldConfirm" placeholder="Confirm Password">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn"
                    data-loading-text="Loading...">SIGN UP</button>
            </div>
            <div class="my-2 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                </div>
                <a href="#" class="auth-link text-black">Forgot password?</a>
            </div>
            <div class="mb-2">
                <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="mdi mdi-facebook mr-2"></i>Connect using facebook </button>
            </div>
            <div class="text-center mt-4 font-weight-light"> Already have a account? <a href="{{ route('admin.login') }}"
                    class="text-primary">Login</a>
            </div>
        </form>
    </div>
@endsection
