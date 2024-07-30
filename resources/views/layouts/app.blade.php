<!DOCTYPE html>
<html>
<head>
    <title>Laravel 10 Task List App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('styles')
</head>
<body class="container mx-auto mt-10 mb-10 max-w-lg">
    <div>
        <h1 class="text-2xl mb-2">
            @yield('title')
        </h1>
        <div>
            @if (session()->has('success'))
                <div>{{ session('success')}}</div>
            @endif
            @yield('content')
        </div>
    </div>
</html>