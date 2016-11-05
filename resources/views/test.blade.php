@extends('layouts.app')

@php
$allowResponse = false;
@endphp

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2>Test Form</h2>

        @if (isset($contents))
            <p>Below are all of the items currently stored on S3...</p>
            <ul>
                @foreach ($contents as $content)
                    <li><a href="https://s3-eu-west-1.amazonaws.com/popapi/{{ $content['path'] }}">{{ $content['filename'] }}</a></li>
                @endforeach
            </ul>
        @endif

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
