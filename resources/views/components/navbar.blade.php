<div class="border-b border-border px-4">
    <nav class="uk-navbar" uk-navbar="">
        <div class="uk-navbar-left gap-x-4 lg:gap-x-6">
            <div class="uk-navbar-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </div>
            <div class="uk-navbar-item w-[250px]">
                <button class="uk-button uk-button-default w-full " type="button" aria-haspopup="true">
                    <div class="flex flex-1 items-center gap-2 truncate"><span
                            class="relative flex h-5 w-5 shrink-0 overflow-hidden rounded-full"> <img
                                class="aspect-square h-full w-full grayscale" alt="Alicia Koch"
                                src="https://avatar.vercel.sh/personal.png"> </span> <span class="">{{ Auth::user()->currentTeam->name }}</span>
                    </div>
                    <span class="size-4 opacity-50"> <uk-icon icon="chevrons-up-down"></uk-icon> </span></button>
                <div class="uk-drop uk-dropdown w-[250px]" uk-dropdown="mode: click; pos: bottom-center">
                    <ul class="uk-dropdown-nav uk-nav">
                        <li class="uk-nav-header">Personal Team</li>
                        <li class="uk-active">
                            <x-switchable-team :team="Auth::user()->personalTeam()" />
                        </li>
                        <li class="mt-3"></li>
                        <li class="uk-nav-header">Other Teams</li>
                        <!-- Team Switcher -->
                        @if (Auth::user()->allTeams()->count() > 1)
                            @foreach (Auth::user()->allTeamsExceptPersonalTeam() as $team)
                                <x-switchable-team :team="$team" />
                            @endforeach
                        @endif

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <li>
                            <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                <uk-icon class="mr-2" icon="circle-plus"></uk-icon> {{ __('Create New Team') }}
                            </x-responsive-nav-link>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>
            <ul class="uk-navbar-nav gap-x-4 lg:gap-x-6">
                <li class="uk-active">
                    <a href="{{ route('goals') }}" uk-toggle="" role="button" uk-tooltip="Goals">
                        <uk-icon icon="goal"></uk-icon>
                    </a>
                </li>
                <li>
                    <a href="#" uk-toggle="" role="button">
                        <uk-icon icon="workflow"></uk-icon>
                    </a>
                </li>
                <li>
                    <a href="#" uk-toggle="" role="button">
                        <uk-icon icon="brain"></uk-icon>
                    </a>
                </li>
                <li>
                    <a href="#" uk-toggle="" role="button" uk-tooltip="Debugger">
                        <uk-icon icon="bug-play"></uk-icon>
                    </a>
                </li>
{{--                <li><a href="#demo" uk-toggle="" role="button">Tools</a></li>--}}
{{--                <li><a href="#demo" uk-toggle="" role="button">Memory</a></li>--}}
            </ul>
        </div>
        <div class="uk-navbar-right gap-x-4 lg:gap-x-6">
            <div class="uk-navbar-item w-[150px] lg:w-[300px]">
                <input class="uk-input" placeholder="Search" type="text">
            </div>

            <div class="uk-navbar-item">
                <a class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-accent ring-ring focus:outline-none focus-visible:ring-1"
                    href="#" role="button" aria-haspopup="true"> <span
                        class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-full"> <img
                            class="aspect-square h-full w-full" alt="@shadcn"
                            src="https://api.dicebear.com/8.x/lorelei/svg?seed=sveltecult"> </span> </a>
                <div class="uk-drop uk-dropdown" uk-dropdown="mode: click; pos: bottom-right">
                    <ul class="uk-dropdown-nav uk-nav">
                        <li class="px-2 py-1.5 text-sm">
                            <div class="flex flex-col space-y-1"><p class="text-sm font-medium leading-none">
                                    sveltecult</p>
                                <p class="text-xs leading-none text-muted-foreground">
                                    leader@sveltecult.com
                                </p></div>
                        </li>
                        <li class="uk-nav-divider"></li>
                        <li><a class="uk-drop-close justify-between" href="#demo" uk-toggle="" role="button">
                                Profile
                                <span class="ml-auto text-xs tracking-widest opacity-60">
⇧⌘P
</span> </a></li>
                        <li><a class="uk-drop-close justify-between" href="#demo" uk-toggle="" role="button">
                                Billing
                                <span class="ml-auto text-xs tracking-widest opacity-60">
⌘B
</span> </a></li>
                        <li><a class="uk-drop-close justify-between" href="#demo" uk-toggle="" role="button">
                                Settings
                                <span class="ml-auto text-xs tracking-widest opacity-60">
⌘S
</span> </a></li>
                        <li><a class="uk-drop-close justify-between" href="#demo" uk-toggle="" role="button">
                                New Team
                            </a></li>
                        <li class="uk-nav-divider"></li>
                        <li><a class="uk-drop-close justify-between" href="" uk-toggle="" role="button">
                                Logout
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
