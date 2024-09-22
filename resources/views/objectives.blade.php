<x-panel-layout>
    <x-slot name="title">
        Objectives
    </x-slot>

    @foreach($objectives as $objective)
        <div class="uk-card uk-card-default uk-card-body uk-margin">
            <h3 class="uk-card-title">{{ $objective->title }}</h3>
            <p>{{ $objective->description }}</p>
            <div class="uk-flex uk-flex-between">
                <a href="{{ route('objectives.show', $objective) }}" class="uk-button uk-button-text">View</a>
                <a href="{{ route('objectives.edit', $objective) }}" class="uk-button uk-button-text">Edit</a>
            </div>
        </div>
    @endforeach

    <div class="uk-flex-top uk-modal" id="create" uk-modal="">
        <div class="uk-margin-auto-vertical uk-modal-dialog" role="dialog" aria-modal="true">
            <div class="uk-modal-header">
                <div class="uk-modal-title">Create a new objective</div>
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
        <uk-theme-switcher></uk-theme-switcher>
    </div>

</x-panel-layout>
