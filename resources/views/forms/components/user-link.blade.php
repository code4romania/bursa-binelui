<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    @php
        $user = $getRecord()->getAdministrator();
    @endphp
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer }">
        <a href="{{ route('filament.resources.users.edit', $user->id) }}" target="_blank"> {{ $user->name}}</a>

    </div>
</x-dynamic-component>
