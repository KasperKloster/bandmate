<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    @include('layouts.partials.google._tagmanager-head')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}"  media="screen,projection"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600|Work+Sans:400,500,600&display=swap" rel="stylesheet">
    @yield('style')
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title') | BandMate</title>
    <meta name="description" content="@yield('meta-description')">
    @yield('schema')
  </head>
  <body>
  @include('layouts.partials.google._tagmanager-body')
