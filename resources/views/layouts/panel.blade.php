<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg"/>
    <meta name="viewport" content="width=device-width"/>
    <title>Agents</title>
    <link rel="preload" href="{{ asset('fonts/geist-font/fonts/GeistVariableVF.woff2') }}" as="font"
          type="font/woff2" crossorigin/>
    <link rel="preload" href="{{ asset('fonts/geist-font/fonts/GeistMonoVariableVF.woff2') }}" as="font"
          type="font/woff2" crossorigin/>
    <link rel="stylesheet" href="{{ asset('fonts/geist-font/style.css') }}"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        const htmlElement = document.documentElement;

        if (
            localStorage.getItem("mode") === "dark" ||
            (!("mode" in localStorage) &&
                window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            htmlElement.classList.add("dark");
        } else {
            htmlElement.classList.remove("dark");
        }

        htmlElement.classList.add(localStorage.getItem("theme") || "uk-theme-zinc");
    </script>
</head>

<body class="hidden bg-background font-geist-sans text-foreground antialiased md:block">
<x-navbar></x-navbar>
<div class="flex-1 space-y-4 p-8 pt-6">
    <div class="flex items-center justify-between space-y-2">
        <h2 class="text-3xl font-bold tracking-tight">Goals</h2>
        <div class="flex items-center space-x-2">
            <button class="uk-button uk-button-primary" uk-toggle="#create-goal">
                <uk-icon icon="plus" class="mr-1"></uk-icon> Create Goal
            </button>
        </div>
    </div>
    <div class="space-y-4">
        <ul class="uk-tab-alt max-w-96">
            <li class="uk-active"> <a href="#demo" uk-toggle="" role="button">Draft</a></li>
            <li><a href="#demo" uk-toggle="" role="button">Live</a></li>
            <li><a href="#demo" uk-toggle="" role="button">Paused</a> </li>
            <li><a href="#demo" uk-toggle="" role="button">Error</a></li>
        </ul>
        <main>
            {{ $slot }}
        </main>
    </div>
</div>

<script src="/js/htmx@2.0.0/htmx.min.js"></script>
</body>

</html>
