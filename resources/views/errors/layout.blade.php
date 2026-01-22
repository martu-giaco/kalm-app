<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Error')</title>
    <style>
        .error-container {
            text-align: center;
            padding: 40px;
        }
        .error-code {
            font-size: 72px;
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="error-container">
        @yield('content')

        @if(app()->environment('local'))
            <div class="debug-info">
                {{ $exception->getMessage() }}
            </div>
        @endif
    </div>
</body>
</html>

// resources/views/errors/404.blade.php
@extends('errors.layout')
@section('title', '404 Not Found')
@section('content')
    <div class="error-code">404</div>
    <h1>Page Not Found</h1>
    <p>The page you're looking for doesn't exist.</p>
    <a href="{{ url('/') }}">Return Home</a>
@endsection

// resources/views/errors/500.blade.php
@extends('errors.layout')
@section('title', '500 Server Error')
@section('content')
    <div class="error-code">500</div>
    <h1>Server Error</h1>
    <p>We are experiencing some technical difficulties.</p>
    <p>Please try again later.</p>
@endsection

// resources/views/errors/4xx.blade.php
@extends('errors.layout')
@section('title', 'Client Error')
@section('content')
    <div class="error-code">{{ $exception->getStatusCode() }}</div>
    <h1>Oops! Something went wrong</h1>
    <p>{{ $exception->getMessage() ?: 'An error occurred while processing your request.' }}</p>
@endsection
