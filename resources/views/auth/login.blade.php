@extends('layouts.auth')

@section('page_title')
    Login
@endsection

@section('page_content')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('login') }}" class="h5 font-weight-bold">
                    <img src="{{ asset('assets/images/WebMan_128.png') }}" alt="{{ config('app.name') }} Logo" width="32px"
                        height="auto" class="mr-1">
                    {{ config('app.name') }}
                </a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                @session('status_success')
                    <div class="alert alert-success">
                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                        <span>{{ $value }}</span>
                    </div>
                @endsession

                @session('status_danger')
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        <span>{{ $value }}</span>
                    </div>
                @endsession

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            placeholder="username" id="username" name="username" value="{{ old('username') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-circle"></span>
                            </div>
                        </div>
                        @error('username')
                            <span id="username-error" class="error invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="password" id="password" name="password">
                        <div class="input-group-append" onclick="onPasswordHelpClick(event, 'password', 'passwordIcon')">
                            <div class="input-group-text">
                                <span class="fas fa-eye" id="passwordIcon"></span>
                            </div>
                        </div>
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
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0">
                        <a href="{{ route('password.request') }}">Forgot Password</a>
                    </p>
                    <p class="mb-0">
                        <a href="{{ config('app.dev_url') }}" class="text-center">Contact Us</a>
                    </p>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection

@section('page_styles')
@endsection

@section('page_scripts')
    <!-- Input Helper -->
    <script src="{{ asset('assets/scripts/input_helper.js') }}"></script>
@endsection
