<x-panel-layout>
    <div class="text-center mt-12 border border-dashed rounded-2xl p-6 bg-zinc-50">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
             aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
        </svg>
        <h3 class="mt-2 mb-3 font-semibold text-gray-900">No goals</h3>
        <x-flux::text>
            Some helpful onboarding text explaining what goals are and how to get started.
        </x-flux::text>
        <div class="m-auto max-w-full max-lg:min-w-fit lg:max-w-96  flex justify-center">
            <x-flux::button href="{{ route('goals.create') }}" icon="plus" variant="primary" class="mt-6 pr-6">
                New goal
            </x-flux::button>
        </div>
    </div>
</x-panel-layout>
