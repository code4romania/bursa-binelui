<form
    wire:submit.prevent="handle"
    class="space-y-8"
>
    {{ $this->form }}

    <x-filament::button
        type="submit"
        form="handle"
        class="w-full"
    >
        {{ __('auth.welcome.submit') }}
    </x-filament::button>
</form>
