<x-panel-layout>
    <x-slot name="header">
        <x-flux::heading-with-action size="xl" level="1">
            {{ $goal->title }}
            <x-slot name="actions">
                @empty($goal->tasks)
                <x-flux::button color="indigo" icon-trailing="sparkles">
                    Generate Tasks
                </x-flux::button>
                @else
                <x-flux::badge color="green" icon="arrow-trending-up">
                    {{ str($goal->priority)->replace('_', ' ')->title() }}
                </x-flux::badge>
                <x-flux::badge color="orange" icon="exclamation-triangle">
                    {{ str($goal->status)->replace('_', ' ')->title() }}
                </x-flux::badge>
                <x-flux::badge color="red" icon="bell-alert">
                    {{ str($goal->risk_level)->replace('_', ' ')->title() }}
                </x-flux::badge>
                    @endempty
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
