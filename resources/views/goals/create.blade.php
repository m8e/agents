<x-panel-layout>
    <x-slot name="header">
        <x-flux::heading size="xl" level="1">
            Create a new goal
        </x-flux::heading>
        <flux:subheading size="lg" class="mb-2 mt-2">
            Some subheader
        </flux:subheading>
    </x-slot>

    <div class="m-auto  max-w-full max-lg:min-w-fit lg:max-w-96  flex justify-center">
        <flux:fieldset>
            <flux:checkbox.group label="Type of goal">
                <flux:checkbox checked
                               value="once"
                               label="One time"
                               description="A goal that will run only once."
                />
                <flux:checkbox
                    value="schedule"
                    label="Scheduled"
                    description="A goal that will run on a schedule."
                />
                <flux:checkbox
                    value="long"
                    label="Long term"
                    description="A goal that will run for a long time, and possible has no end date."
                />
            </flux:checkbox.group>
            <flux:input type="email" label="Email" />
            <flux:input type="password" label="Password" />
            <flux:input type="date" max="2999-12-31" label="Date" />
        </flux:fieldset>
    </div>
</x-panel-layout>
