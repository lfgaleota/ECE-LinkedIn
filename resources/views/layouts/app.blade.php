@section( 'scripts' )
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/riot@3.9/riot+compiler.min.js"></script>
@endsection

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield( 'styles' )
</head>
<body>
    <div id="app">
        @include('app.inc.menu')

        @yield('content')
    </div>

    <!-- Scripts -->
    @yield( 'scripts' )
</body>
</html>