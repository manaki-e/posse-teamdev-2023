<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @if (request()->is('items') || request()->is('items/*'))
    <title>{{"Peer Product Share"}}</title>
    <link rel="icon" href="{{ asset('icon-pps.ico') }}" type="image/x-icon">
    @elseif (request()->is('events') || request()->is('events/*'))
    <title>{{"Peer Event"}}</title>
    <link rel="icon" href="{{ asset('icon-pe.ico') }}" type="image/x-icon">
    @elseif (request()->is('requests') || request()->is('requests/*'))
    <title>{{"Peer Request"}}</title>
    <link rel="icon" href="{{ asset('icon-pr.ico') }}" type="image/x-icon">
    @else
    <title>{{"Peer Perk"}}</title>
    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/x-icon">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP&family=Patua+One&display=swap');

        .font-family-karla {
            font-family: karla;
        }

        .font-sans {
            font-family: 'Noto Sans JP', sans-serif;
        }

        .font-patua {
            font-family: 'Patua One', cursive;
        }
    </style>
</head>

<body class="user-bg-gray font-sans text-gray-600">
    <header class="bg-white">
        {{ $header_slot }}
    </header>
    {{ $body_slot }}
</body>
