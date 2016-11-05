@extends('layouts.app')

@php
$allowResponse = false;
@endphp

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2>Test Form</h2>

        {{ Form::open(['method' => 'POST', 'url' => 'test', 'files' => true]) }}

        <div class="form-group">
            {{ Form::label('document') }}
            {{ Form::file('document') }}
            <p class="help-block">File must be of image type.</p>
        </div>

        <div class="form-group">
            {{ Form::submit('Submit', ['class' => 'btn btn-default']) }}
        </div>

        {{ Form::close() }}
    </div>
@endsection
