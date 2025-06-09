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

<div class="container max-w-6/10 mx-auto p-5">
    @yield('content')
</div>

</body>
</html>
