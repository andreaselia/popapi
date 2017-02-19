@php $allowResponse = false @endphp

@extends('layouts.app')

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2>Test Form</h2>

        @if (isset($contents))
            <p>Below are all of the items currently stored on S3...</p>
            <ul>
                @foreach ($contents as $content)
                    <li>
                        <strong>{{ $content['filename'] }}</strong>

                        @if (isset($content['data']))
                            @foreach ($content['data'] as $data)
                                <ol><a href="https://s3-eu-west-1.amazonaws.com/popapi/{{ $data['path'] }}">{{ $data['path'] }}</a></ol>
                            @endforeach
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
