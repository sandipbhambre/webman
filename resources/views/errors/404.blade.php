@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))

@section('home_link')
    <p>
        Back to <a href="{{ route('dashboard') }}">Home</a>
    </p>
@endsection
