<x-panel-layout>
    <x-slot name="header">
        <x-flux::heading-with-action size="xl" level="1">
            {{ $goal->title }}
            <x-slot name="actions">
                <x-flux::badge size="lg" color="indigo">
                    Priority: {{ $goal->priority }}
                </x-flux::badge>
                <x-flux::badge size="lg" color="indigo">
                    Status: {{ $goal->status }}
                </x-flux::badge>
                <x-flux::badge size="lg" color="indigo">
                    Risk: {{ $goal->risk_level }}
                </x-flux::badge>
            </x-slot>
        </x-flux::heading-with-action>
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
                @foreach($goal->tasks->topLevel() as $task)
                    @include('goals.task-row', ['task' => $task])
                    @foreach($task->children as $child1)
                        @include('goals.task-row', ['task' => $child1, 'level' => 1])
                        @foreach($child1->children as $child2)
                            @include('goals.task-row', ['task' => $child2, 'level' => 2])
                        @endforeach
                    @endforeach
                @endforeach
            </flux:rows>
        </flux:table>

</x-panel-layout>
