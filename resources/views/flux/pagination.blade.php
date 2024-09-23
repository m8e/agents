@props([
    'paginator' => null,
])

@php
$simple = ! $paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;
@endphp

@if ($simple)
    <div class="pt-3 border-t border-zinc-100 dark:border-zinc-700 flex justify-between items-center" data-flux-pagination>
        <div></div>

        @if ($paginator->hasPages())
            <div class="flex items-center bg-white border border-zinc-200 rounded-[8px] p-[1px] dark:bg-white/10 dark:border-white/10">
                @if ($paginator->onFirstPage())
                    <div class="flex justify-center items-center size-6 rounded-[6px] text-zinc-300 dark:text-white">
                        <flux:icon.chevron-left variant="micro" />
                    </div>
                @else
                    @if(method_exists($paginator,'getCursorName'))
                        <button type="button" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->previousCursor()->encode() }}" wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                            <flux:icon.chevron-left variant="micro" />
                        </button>
                    @else
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                            <flux:icon.chevron-left variant="micro" />
                        </button>
                    @endif
                @endif

                @if ($paginator->hasMorePages())
                    @if(method_exists($paginator,'getCursorName'))
                        <button type="button" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->nextCursor()->encode() }}" wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                            <flux:icon.chevron-right variant="micro" />
                        </button>
                    @else
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                            <flux:icon.chevron-right variant="micro" />
                        </button>
                    @endif
                @else
                    <div class="flex justify-center items-center size-6 rounded-[6px] text-zinc-300 dark:text-white">
                        <flux:icon.chevron-right variant="micro" />
                    </div>
                @endif
            </div>
        @endif
    </div>
@else
    <div class="pt-3 border-t border-zinc-100 dark:border-zinc-700 flex justify-between items-center max-sm:flex-col-reverse max-sm:gap-2 max-sm:items-end" data-flux-pagination>
        @if ($paginator->total() > 0)
            <div class="text-zinc-500 dark:text-zinc-300 text-xs font-medium whitespace-nowrap">
                Showing {{ \Illuminate\Support\Number::format($paginator->firstItem()) }} to {{ \Illuminate\Support\Number::format($paginator->lastItem()) }} of {{ \Illuminate\Support\Number::format($paginator->total()) }} entries
            </div>
        @else
            <div></div>
        @endif

        @if ($paginator->hasPages())
            <div class="flex items-center bg-white border border-zinc-200 rounded-[8px] p-[1px] dark:bg-white/10 dark:border-white/10">
                @if ($paginator->onFirstPage())
                    <div class="flex justify-center items-center size-6 rounded-[6px] text-zinc-300 dark:text-white">
                        <flux:icon.chevron-left variant="micro" />
                    </div>
                @else
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                        <flux:icon.chevron-left variant="micro" />
                    </button>
                @endif

                @foreach (\Livewire\invade($paginator)->elements() as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <div
                            aria-disabled="true"
                            class="cursor-default flex justify-center items-center text-xs size-6 rounded-[6px] font-medium dark:text-white text-zinc-400"
                        >{{ $element }}</div>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <div
                                    wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}"
                                    aria-current="page"
                                    class="cursor-default flex justify-center items-center text-xs size-6 rounded-[6px] font-medium dark:text-white  text-zinc-800"
                                >{{ $page }}</div>
                            @else
                                <button
                                    wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}"
                                    wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                    type="button"
                                    class="text-xs size-6 rounded-[6px] text-zinc-400 font-medium dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white"
                                >{{ $page }}</button>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                        <flux:icon.chevron-right variant="micro" />
                    </button>
                @else
                    <div class="flex justify-center items-center size-6 rounded-[6px] text-zinc-300 dark:text-white">
                        <flux:icon.chevron-right variant="micro" />
                    </div>
                @endif
            </div>
        @endif
    </div>
@endif


