<!doctype html>
<html>
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    @vite('resources/css/app.css')
</head>
<body>
@include('layout._header')

<div class="p-5">
    <div class="container mx-auto max-w-screen-xl">
        @yield('content')
    </div>
</div>

</body>
</html>
