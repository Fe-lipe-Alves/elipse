<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="theme-color" content="#000000"/>
    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"/>--}}
</head>
<body class="text-blueGray-700 bg-blueGray-50 antialiased">
<noscript>You need to enable JavaScript to run this app.</noscript>

<div id="root">

    <x-layout.sidebar />

    <div class="relative md:ml-64 bg-blueGray-50">
        <x-layout.header />

        <div class="spacer-top py-10"></div>

        <div class="p-10">
            {{ $slot }}
        </div>


    </div>

    <form action="" method="post" id="formGeneric" class="hidden">
        @csrf
        @method('post')
    </form>
</div>

</body>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
    charset="utf-8"
></script>
<script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js" charset="utf-8"></script>
<script>
    var user = JSON.parse('{!! \Illuminate\Support\Facades\Auth::user()->toJson() !!}')
</script>
<script src="{{ asset('js/app.js') }}"></script>

@isset($scripts)
    {{ $scripts }}
@endisset
</html>
