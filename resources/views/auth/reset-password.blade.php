@extends('layouts.auth')

@section('page_title')
    Reset Password
@endsection

@section('page_content')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('password.reset', ['token' => $token]) }}" class="h5 font-weight-bold">
                    <img src="{{ asset('assets/images/WebMan_128.png') }}" alt="{{ config('app.name') }} Logo" width="32px"
                        height="auto" class="mr-1">
                    {{ config('app.name') }}
                </a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">
                    Reset Password
                </p>

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

                <form action="{{ route('password.update') }}" method="post">
                    @csrf
                    <input type="hidden" id="token" name="token" value="{{ $token }}">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="email"
                            id="email" name="email" value="{{ old('email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <span id="email-error" class="error invalid-feedback">
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
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="password_confirmation" id="password_confirmation" name="password_confirmation">
                        <div class="input-group-append"
                            onclick="onPasswordHelpClick(event, 'password_confirmation', 'password_confirmation_icon')">
                            <div class="input-group-text">
                                <span class="fas fa-eye" id="password_confirmation_icon"></span>
                            </div>
                        </div>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                Reset Password
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0">
                        <a href="{{ route('login') }}">Login</a>
                    </p>
                    <p class="mb-0">
                        <a href="{{ config('app.app_dev_url') }}" class="text-center">Contact Us</a>
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
