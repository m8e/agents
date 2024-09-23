@php
$attributes = $attributes->merge([
    'variant' => 'subtle',
    'class' => '-mr-1',
    'square' => true,
    'size' => 'sm',
]);
@endphp

<flux:button
    :$attributes
    x-data="{ copied: false }"
    x-on:click="copied = ! copied; navigator.clipboard && navigator.clipboard.writeText($el.closest('[data-flux-input]').querySelector('input').value); setTimeout(() => copied = false, 2000)"
    x-bind:data-copyable-copied="copied"
>
    <flux:icon.clipboard-document-check variant="mini" class="hidden [[data-copyable-copied]>&]:block" />
    <flux:icon.clipboard-document variant="mini" class="block [[data-copyable-copied]>&]:hidden" />
</flux:button>
