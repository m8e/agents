@props([
    'level' => 0,
])

<flux:row :key="$task->id">
    <flux:cell>
        @if($level)
            @for($i = 0; $i < $level; $i++)
                &nbsp;&nbsp;&nbsp;&nbsp;
            @endfor
            &cir;
        @endif
        @empty($level)<strong>{{ $task->title }}</strong>@else{{ $task->title }}@endempty
    </flux:cell>
    <flux:cell><flux:badge color="green" size="sm" inset="top bottom">{{ $task->status }}</flux:badge></flux:cell>
    <flux:cell><flux:badge color="green" size="sm" inset="top bottom">{{ $task->priority }}</flux:badge></flux:cell>
    <flux:cell></flux:cell>
    <flux:cell>{{ $task->created_at->format('M d, Y') }}</flux:cell>
    <flux:cell>30%</flux:cell>
    <flux:cell>&DotDot;</flux:cell>
</flux:row>
