@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized'))

@section('home_link')
    <p>
        Back to <a href="{{ route('dashboard') }}">Home</a>
    </p>
@endsection
