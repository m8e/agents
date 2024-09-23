<x-panel-layout>
    <x-slot name="title">
        Goals
    </x-slot>
    <x-slot name="actions">
        <button class="uk-button uk-button-primary" uk-toggle="#create-goal">
            <uk-icon icon="plus" class="mr-1"></uk-icon> Create Goal
        </button>
    </x-slot>
    <x-slot name="subnav">
        <ul class="uk-tab-alt max-w-96">
            <li class="uk-active"> <a href="#demo" uk-toggle="" role="button">Draft</a></li>
            <li><a href="#demo" uk-toggle="" role="button">Live</a></li>
            <li><a href="#demo" uk-toggle="" role="button">Paused</a> </li>
            <li><a href="#demo" uk-toggle="" role="button">Error</a></li>
        </ul>
    </x-slot>

    @empty($goals)
        <div class="uk-alert-warning" uk-alert>
            <p>No goals found.</p>
        </div>
    @else
        @foreach($goals as $goal)
            <div class="uk-card uk-card-default uk-card-body uk-margin uk-flex uk-flex-middle">
                <div class="uk-flex-none uk-flex uk-flex-middle">
                    <uk-icon icon="goal" class="text-red-500" height="32" width="32" stroke-width="2" uk-cloak></uk-icon>
                </div>
                <div class="uk-flex-1 uk-margin-left">
                    <h3 class="uk-card-title">{{ $goal->title }}</h3>
                    <div class="uk-margin">
                        <progress class="uk-progress" value="{{ rand(1,100) }}" max="100"></progress>
                        <div class="uk-flex uk-flex-between">
                            <a href="{{ route('goals.show', $goal) }}" class="uk-button uk-button-text">View</a>
                            <a href="{{ route('goals.edit', $goal) }}" class="uk-button uk-button-text">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endempty

    <div class="uk-flex-top uk-modal" id="create-goal" uk-modal="create-goal">
        <div class="uk-margin-auto-vertical uk-modal-dialog" role="dialog" aria-modal="true">
            <div class="uk-modal-header">
                <div class="uk-modal-title">What is your goal?</div>
            </div>
            <div class="uk-modal-body">
                Form here
            </div>
            <div class="uk-modal-footer">
                <button class="uk-modal-close uk-button uk-button-primary">
                    Dismiss
                </button>
            </div>
        </div>
    </div>
</x-panel-layout>
