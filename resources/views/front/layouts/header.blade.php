<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/slick.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}"/>
    <link rel="stylesheet"
          href="{{ asset('css/simple-line-icons.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/simple-line-icons.css') }}">
    <link href="{{ asset('css/jquery.notifyBar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="{{ asset('assets/css/parsley.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.rating.css') }}" rel="stylesheet">
    <title>Hardware</title>
    @yield('extra-css')
</head>
<body>
<div id="page-wrapper">
