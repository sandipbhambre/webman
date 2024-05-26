@extends('errors::minimal')

@section('title', __('Payment Required'))
@section('code', '402')
@section('message', __('Payment Required'))

@section('home_link')
    <p>
        Back to <a href="{{ route('dashboard') }}">Home</a>
    </p>
@endsection
