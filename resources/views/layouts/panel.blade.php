<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    <title>Agents</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxStyles
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:header container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="FA" class="max-lg:hidden dark:hidden" />
    <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc." class="max-lg:!hidden hidden dark:flex" />

    <flux:navbar class="max-lg:hidden">
        <flux:modal.trigger name="change-workspace">
            <flux:navbar.item>Workspace</flux:navbar.item>
        </flux:modal.trigger>

        <flux:navbar.item icon="trophy" badge="12" href="#">Goals</flux:navbar.item>
        <flux:navbar.item icon="document-text" href="#">Activity</flux:navbar.item>
    </flux:navbar>

    <flux:spacer />

    <flux:navbar class="mr-4">
        <flux:navbar.item icon="magnifying-glass" href="#" label="Search" />
        <flux:navbar.item class="max-lg:hidden" icon="cog-6-tooth" href="#" label="Settings" />
        <flux:navbar.item class="max-lg:hidden" icon="information-circle" href="#" label="Help" />
    </flux:navbar>

    <flux:profile avatar="https://fluxui.dev/img/demo/user.png" />
</flux:header>


<flux:sidebar stashable sticky class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc." class="px-2 dark:hidden" />
    <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc." class="px-2 hidden dark:flex" />

    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" href="#" current>Home</flux:navlist.item>
        <flux:navlist.item icon="inbox" badge="12" href="#">Inbox</flux:navlist.item>
        <flux:navlist.item icon="document-text" href="#">Documents</flux:navlist.item>
        <flux:navlist.item icon="calendar" href="#">Calendar</flux:navlist.item>

        <flux:navlist.group expandable heading="Favorites" class="max-lg:hidden">
            <flux:navlist.item href="#">Marketing site</flux:navlist.item>
            <flux:navlist.item href="#">Android app</flux:navlist.item>
            <flux:navlist.item href="#">Brand guidelines</flux:navlist.item>
        </flux:navlist.group>
    </flux:navlist>

    <flux:spacer />

    <flux:navlist variant="outline">
        <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item>
        <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item>
    </flux:navlist>
</flux:sidebar>

<flux:main container>
    <flux:heading size="xl" level="1">Good afternoon, Olivia</flux:heading>

    <flux:subheading size="lg" class="mb-6">Here's what's new today</flux:subheading>

    <flux:separator variant="subtle" />

    {{ $slot }}
</flux:main>

<flux:modal name="change-workspace" class="md:w-96 space-y-6">
    <div>
        <flux:heading size="lg">Update profile</flux:heading>
        <flux:subheading>Make changes to your personal details.</flux:subheading>
    </div>

    <flux:input label="Name" placeholder="Your name" />

    <flux:input label="Date of birth" type="date" />

    <div class="flex">
        <flux:spacer />

        <flux:button type="submit" variant="primary">Save changes</flux:button>
    </div>
</flux:modal>

@fluxScripts
</body>
{{--<body class="hidden bg-background font-geist-sans text-foreground antialiased md:block">--}}
{{--<x-navbar></x-navbar>--}}
{{--<div class="flex-1 space-y-4 p-8 pt-6">--}}
{{--    <div class="flex items-center justify-between space-y-2">--}}
{{--        <h2 class="text-3xl font-bold tracking-tight">--}}
{{--            {{ $title }}--}}
{{--        </h2>--}}
{{--        <div class="flex items-center space-x-2">--}}
{{--            {{ $actions ?? '' }}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="space-y-4">--}}
{{--        {{ $subnav ?? '' }}--}}
{{--        <main>--}}
{{--            {{ $slot }}--}}
{{--        </main>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<script src="/js/htmx@2.0.0/htmx.min.js"></script>--}}
{{--</body>--}}

</html>
