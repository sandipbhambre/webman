@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))

@section('home_link')
    <p>
        Back to <a href="{{ route('dashboard') }}">Home</a>
    </p>
@endsection
