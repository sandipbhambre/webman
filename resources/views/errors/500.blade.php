@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))

@section('home_link')
    <p>
        Back to <a href="{{ route('dashboard') }}">Home</a>
    </p>
@endsection
