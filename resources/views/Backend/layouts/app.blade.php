<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Argon Dashboard') }}</title>
    <!-- Favicon -->
{{--        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">--}}
<!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Extra details for Live View on GitHub Pages -->

    <!-- Icons -->
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-multiselect.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('select2/select2.min.css')}}">

    <link href="{{ asset('assets/css/parsley.css') }}" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
@yield('extra-css')

<!-- Argon CSS -->
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
</head>
<body class="{{ $class ?? '' }}">
@auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @include('Backend.layouts.navbars.sidebar')
@endauth

<div class="main-content">
    @include('Backend.layouts.navbars.navbar')
    @yield('content')
</div>

@guest()
    @include('Backend.layouts.footers.guest')
@endguest

<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/js/sweetalert.js')}}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
{{--<script src="{{ asset('assets/js/bootstrap-multiselect.js')}}"></script>--}}
<script src="{{asset('select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/js/parsley.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@stack('js')
@yield('extra-js')

<!-- Argon JS -->
<script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
<!-- Moment -->
<script src="{{ asset('js/moment.js') }}"></script>

</body>
</html>
