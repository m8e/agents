<x-panel-layout>
    <x-slot name="title">
        Goals
    </x-slot>

    @empty($goals)
        <div class="uk-alert-warning" uk-alert>
            <p>No goals found.</p>
        </div>
    @else
        @foreach($goals as $goal)
            <div class="uk-card uk-card-default uk-card-body uk-margin">
                <h3 class="uk-card-title">{{ $goal->title }}</h3>
                <p>{{ $goal->description }}</p>
                <div class="uk-flex uk-flex-between">
                    <a href="{{ route('goals.show', $goal) }}" class="uk-button uk-button-text">View</a>
                    <a href="{{ route('goals.edit', $goal) }}" class="uk-button uk-button-text">Edit</a>
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
