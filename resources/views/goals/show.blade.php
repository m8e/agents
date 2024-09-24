<x-panel-layout>
    <x-slot name="header">
        <x-flux::heading size="xl" level="1">
            {{ $goal->title }}
        </x-flux::heading>
        <flux:subheading size="lg" class="mb-6 mt-2">
            {{ $goal->description }}
        </flux:subheading>
    </x-slot>
        <flux:table class="mt-4">
            <flux:columns>
                <flux:column>Task</flux:column>
                <flux:column>Status</flux:column>
                <flux:column>Priority</flux:column>
                <flux:column>Agents</flux:column>
                <flux:column>Estimate</flux:column>
                <flux:column>Progress</flux:column>
                <flux:column>Progress</flux:column>
            </flux:columns>

            <flux:rows>
                @foreach($goal->tasks as $task)
                    <flux:row :key="$task->id">
                        <flux:cell>{{ $task->title }}</flux:cell>
                        <flux:cell><flux:badge color="green" size="sm" inset="top bottom">{{ $task->status }}</flux:badge></flux:cell>
                        <flux:cell><flux:badge color="green" size="sm" inset="top bottom">{{ $task->priority }}</flux:badge></flux:cell>
                        <flux:cell></flux:cell>
                        <flux:cell>{{ $task->created_at->format('M d, Y') }}</flux:cell>
                        <flux:cell>30%</flux:cell>
                        <flux:cell>&DotDot;</flux:cell>
                    </flux:row>
                @endforeach
            </flux:rows>
        </flux:table>

</x-panel-layout>
