@php $allowResponse = false @endphp

@extends('layouts.app')

@section('content')
    <div class="col-md-6 col-md-offset-3 text-center">
        <h2>404</h2>
        <p>
            Page not found, <a href="{{ url('/') }}">go home</a>?
        </p>
    </div>
@endsection
