@php $allowResponse = false @endphp

@extends('layouts.app')

@section('content')
    <div class="col-md-1 col-md-offset-3">
        <h3>Overview</h3>
        <ul class="resources">
            <li><a href="#">Introduction</a></li>
            <li><a href="#">Pagination</a></li>
            <li><a href="#">Rate Limiting</a></li>
        </ul>

        <h3>Resources</h3>
        <ul class="resources">
            <li><a href="#">Results</a></li>
            <li><a href="#">Collections</a></li>
            <li><a href="#">Examples</a></li>
        </ul>
    </div>
    <div class="col-md-4 col-md-offset-1">
        <h2>Introduction</h2>
        <p>
            This documentation will help you get started using POPAPI and provides all of the information needed to get started as well as providing educational examples for all resources.
        </p>

        <h2>Rate Limiting</h2>
        <p>
            We do not currently limit the API usage, please don't abuse our services. POPAPI is free and open to use by anyone, but please try to keep in mind that other people are also using the service and try to do the following...

            <ul>
                <li>Locally cache resources whenever you request them</li>
                <li>Use the paginated results rather than spamming the system to cache all data</li>
            </ul>
        </p>

        @if (isset($stats))
        <h2>Statistics</h2>
        <p>
            <ul>
                <li><strong>Collections:</strong> {{ $stats['collections'] }}</li>
                <li><strong>Results:</strong> {{ $stats['results'] }}</li>
            </ul>
        </p>
        @endif
    </div>
@endsection
