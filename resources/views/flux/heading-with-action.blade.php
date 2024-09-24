<div class="flex justify-between items-center">
    <flux:heading size="xl" level="1">{{ $slot }}</flux:heading>
    <div class="flex space-x-4">
        {{ $actions ?? '' }}
    </div>
</div>
