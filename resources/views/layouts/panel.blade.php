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
    <main>
        {{ $slot }}
    </main>
</div>

<script src="/js/htmx@2.0.0/htmx.min.js"></script>
</body>

</html>
