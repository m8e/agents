<x-panel-layout>

    <x-slot name="header">
        <x-flux::heading-with-action>
            Good afternoon, {{ auth()->user()->name }}
            <x-slot name="actions">
                <flux:modal.trigger name="edit-profile">
                    <flux:button>Edit profile</flux:button>
                </flux:modal.trigger>
                <flux:button href="{{ route('goals.create') }}" icon="plus">New goal</flux:button>
            </x-slot>
        </x-flux::heading-with-action>
        <flux:subheading size="lg" class="mb-6 mt-2">Here's a summary of all your active goals.</flux:subheading>
    </x-slot>

    <flux:table>
        <flux:columns>
            <flux:column>Goal</flux:column>
            <flux:column>Status</flux:column>
            <flux:column>Date</flux:column>
            <flux:column>Progress</flux:column>
        </flux:columns>

        <flux:rows>
            @if($goals->count())
                @foreach($goals as $goal)
                <flux:row :key="$goal->id">
                    <flux:cell><flux:link variant="subtle" href="{{ route('goals.show', $goal) }}">{{ $goal->title }}</flux:link></flux:cell>
                    <flux:cell><flux:badge color="green" size="sm" inset="top bottom">{{ $goal->status }}</flux:badge></flux:cell>
                    <flux:cell>{{ $goal->created_at->format('M d, Y') }}</flux:cell>
                    <flux:cell>30%</flux:cell>
                </flux:row>
                @endforeach
            @endif
        </flux:rows>
    </flux:table>

    <flux:modal name="edit-profile" class="md:w-96 space-y-6">
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

</x-panel-layout>
