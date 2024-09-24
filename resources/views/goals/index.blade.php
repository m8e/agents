<x-panel-layout>
    <flux:table>
        <flux:columns>
            <flux:column>Customer</flux:column>
            <flux:column>Status</flux:column>
            <flux:column>Date</flux:column>
            <flux:column>Progress</flux:column>
        </flux:columns>

        <flux:rows>
            @unless($goals->count())
                @foreach($goals as $goal)
                <flux:row>
                    <flux:cell>{{ $goal->title }}</flux:cell>
                    <flux:cell><flux:badge color="green" size="sm" inset="top bottom">{{ $goal->status }}</flux:badge></flux:cell>
                    <flux:cell>{{ $goal->created_at->format('M d, Y') }}</flux:cell>
                    <flux:cell variant="strong">30%</flux:cell>
                </flux:row>
                @endforeach
            @endunless
        </flux:rows>
    </flux:table>

{{--    @empty($goals)--}}
{{--        <div class="uk-alert-warning" uk-alert>--}}
{{--            <p>No goals found.</p>--}}
{{--        </div>--}}
{{--    @else--}}
{{--        @foreach($goals as $goal)--}}
{{--            <div class="uk-card uk-card-default uk-card-body uk-margin uk-flex uk-flex-middle">--}}
{{--                <div class="uk-flex-none uk-flex uk-flex-middle">--}}
{{--                    <uk-icon icon="goal" class="text-red-500" height="32" width="32" stroke-width="2" uk-cloak></uk-icon>--}}
{{--                </div>--}}
{{--                <div class="uk-flex-1 uk-margin-left">--}}
{{--                    <h3 class="uk-card-title">{{ $goal->title }}</h3>--}}
{{--                    <div class="uk-margin">--}}
{{--                        <progress class="uk-progress" value="{{ rand(1,100) }}" max="100"></progress>--}}
{{--                        <div class="uk-flex uk-flex-between">--}}
{{--                            <a href="{{ route('goals.show', $goal) }}" class="uk-button uk-button-text">View</a>--}}
{{--                            <a href="{{ route('goals.edit', $goal) }}" class="uk-button uk-button-text">Edit</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    @endempty--}}

{{--    <div class="uk-flex-top uk-modal" id="create-goal" uk-modal="create-goal">--}}
{{--        <div class="uk-margin-auto-vertical uk-modal-dialog" role="dialog" aria-modal="true">--}}
{{--            <div class="uk-modal-header">--}}
{{--                <div class="uk-modal-title">What is your goal?</div>--}}
{{--            </div>--}}
{{--            <div class="uk-modal-body">--}}
{{--                Form here--}}
{{--            </div>--}}
{{--            <div class="uk-modal-footer">--}}
{{--                <button class="uk-modal-close uk-button uk-button-primary">--}}
{{--                    Dismiss--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</x-panel-layout>
