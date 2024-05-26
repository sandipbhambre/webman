@extends('layouts.auth')

@section('page_title')
    Forgot Password
@endsection

@section('page_content')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('password.request') }}" class="h5 font-weight-bold">
                    <img src="{{ asset('assets/images/WebMan_128.png') }}" alt="{{ config('app.name') }} Logo" width="32px"
                        height="auto" class="mr-1">
                    {{ config('app.name') }}
                </a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Get Password Reset Link via Email</p>

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

                <form action="{{ route('password.email') }}" method="post">
                    @csrf
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
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                Get Password Reset Link
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
@endsection
