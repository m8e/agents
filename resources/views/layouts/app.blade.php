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

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
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
@include('navbar')
<div class="flex-1 space-y-4 p-8 pt-6">
    <div class="flex items-center justify-between space-y-2"><h2 class="text-3xl font-bold tracking-tight">
            Dashboard</h2>
        <div class="flex items-center space-x-2">
            <button class="uk-button uk-button-default w-[260px]">
                <div class="flex gap-x-2" uk-toggle="#demo" tabindex="0">
                    <span class="size-4">
                        <uk-icon icon="calendar-days"></uk-icon> </span>Jan 20, 2024 - Feb 09, 2024
                </div>
            </button>
            <button class="uk-button uk-button-primary" uk-toggle="#demo">
                Download
            </button>
        </div>
    </div>
    <div class="space-y-4">
        <ul class="uk-tab-alt max-w-96">
            <li class="uk-active"><a href="#demo" uk-toggle="" role="button">Overview</a></li>
            <li><a href="#demo" uk-toggle="" role="button">Analytics</a></li>
            <li><a href="#demo" uk-toggle="" role="button">Reports</a></li>
            <li><a href="#demo" uk-toggle="" role="button">Notifications</a></li>
        </ul>
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div class="uk-card">
                <div class="uk-card-header flex flex-row items-center justify-between"><h3
                        class="text-sm font-medium tracking-tight">Total Revenue</h3> <span
                        class="size-4 text-muted-foreground"> <uk-icon icon="dollar-sign"></uk-icon> </span>
                </div>
                <div class="uk-card-body">
                    <div class="text-2xl font-bold">$45,231.89</div>
                    <p class="text-xs text-muted-foreground">+20.1% from last month</p></div>
            </div>
            <div class="uk-card">
                <div class="uk-card-header flex flex-row items-center justify-between"><h3
                        class="text-sm font-medium tracking-tight">Subscriptions</h3> <span
                        class="size-4 text-muted-foreground"> <uk-icon icon="users"></uk-icon> </span></div>
                <div class="uk-card-body">
                    <div class="text-2xl font-bold">+2350</div>
                    <p class="text-xs text-muted-foreground">+180.1% from last month</p></div>
            </div>
            <div class="uk-card">
                <div class="uk-card-header flex flex-row items-center justify-between"><h3
                        class="text-sm font-medium tracking-tight">Sales</h3> <span
                        class="size-4 text-muted-foreground"> <uk-icon icon="credit-card"></uk-icon> </span></div>
                <div class="uk-card-body">
                    <div class="text-2xl font-bold">+12,234</div>
                    <p class="text-xs text-muted-foreground">+19% from last month</p></div>
            </div>
            <div class="uk-card">
                <div class="uk-card-header flex flex-row items-center justify-between"><h3
                        class="text-sm font-medium tracking-tight">Active Now</h3> <span
                        class="size-4 text-muted-foreground"> <uk-icon icon="chart-line"></uk-icon> </span></div>
                <div class="uk-card-body">
                    <div class="text-2xl font-bold">+573</div>
                    <p class="text-xs text-muted-foreground">+201 since last hour</p></div>
            </div>
        </div>
        <div class="grid gap-4 lg:grid-cols-7">
            <div class="uk-card flex min-h-64 items-center justify-center lg:col-span-4">
                <div class="flex flex-1 items-center justify-center gap-x-2 text-destructive"><span class="size-4"> <uk-icon
                            icon="info"></uk-icon> </span>
                    Graph not available
                </div>
            </div>
            <div class="uk-card lg:col-span-3">
                <div class="uk-card-header"><h3 class="font-semibold leading-none tracking-tight">
                        Recent Sales
                    </h3>
                    <p class="text-sm text-muted-foreground">
                        You made 265 sales this month.
                    </p></div>
                <div class="uk-card-body">
                    <div class="space-y-8">
                        <div class="flex items-center"><span
                                class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full bg-accent"> <img
                                    class="aspect-square h-full w-full" alt="Avatar"
                                    src="https://api.dicebear.com/8.x/lorelei/svg?seed=Olivia Martin"> </span>
                            <div class="ml-4 space-y-1"><p class="text-sm font-medium leading-none">Olivia Martin</p>
                                <p class="text-sm text-muted-foreground">olivia.martin@email.com</p></div>
                            <div class="ml-auto font-medium">+$1,999.00</div>
                        </div>
                        <div class="flex items-center"><span
                                class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full bg-accent"> <img
                                    class="aspect-square h-full w-full" alt="Avatar"
                                    src="https://api.dicebear.com/8.x/lorelei/svg?seed=Jackson Lee"> </span>
                            <div class="ml-4 space-y-1"><p class="text-sm font-medium leading-none">Jackson Lee</p>
                                <p class="text-sm text-muted-foreground">jackson.lee@email.com</p></div>
                            <div class="ml-auto font-medium">+$39.00</div>
                        </div>
                        <div class="flex items-center"><span
                                class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full bg-accent"> <img
                                    class="aspect-square h-full w-full" alt="Avatar"
                                    src="https://api.dicebear.com/8.x/lorelei/svg?seed=Isabella Nguyen"> </span>
                            <div class="ml-4 space-y-1"><p class="text-sm font-medium leading-none">Isabella Nguyen</p>
                                <p class="text-sm text-muted-foreground">isabella.nguyen@email.com</p></div>
                            <div class="ml-auto font-medium">+$299.00</div>
                        </div>
                        <div class="flex items-center"><span
                                class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full bg-accent"> <img
                                    class="aspect-square h-full w-full" alt="Avatar"
                                    src="https://api.dicebear.com/8.x/lorelei/svg?seed=William Kim"> </span>
                            <div class="ml-4 space-y-1"><p class="text-sm font-medium leading-none">William Kim</p>
                                <p class="text-sm text-muted-foreground">will@email.com</p></div>
                            <div class="ml-auto font-medium">+$99.00</div>
                        </div>
                        <div class="flex items-center"><span
                                class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full bg-accent"> <img
                                    class="aspect-square h-full w-full" alt="Avatar"
                                    src="https://api.dicebear.com/8.x/lorelei/svg?seed=Sofia Davis"> </span>
                            <div class="ml-4 space-y-1"><p class="text-sm font-medium leading-none">Sofia Davis</p>
                                <p class="text-sm text-muted-foreground">sofia.davis@email.com</p></div>
                            <div class="ml-auto font-medium">+$39.00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="uk-flex-top uk-modal" id="demo" uk-modal="">
    <div class="uk-margin-auto-vertical uk-modal-dialog" role="dialog" aria-modal="true">
        <div class="uk-modal-header">
            <div class="uk-modal-title">Just a demo</div>
        </div>
        <div class="uk-modal-body">
            The element you clicked is for demonstration purposes only and does
            not lead to actual content. Everything you see here is a simulation
            intended to demonstrate how the UI elements might look and behave in a
            real application.
        </div>
        <div class="uk-modal-footer">
            <button class="uk-modal-close uk-button uk-button-primary">
                Dismiss
            </button>
        </div>
    </div>
    <uk-theme-switcher></uk-theme-switcher>
</div>
<script src="/js/htmx@2.0.0/htmx.min.js"></script>
</body>

</html>
