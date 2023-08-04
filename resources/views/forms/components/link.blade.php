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
    class=" flex text-center justify-items-center object-center align-middle"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer }" class="mx-auto">
            <a href="{{ $getRecord()->getStatuteLinkAttribute() }}" target="_blank"> {{ $getRecord()->getFirstMedia('organizationFilesStatute')->name}}.{{ $getRecord()->getFirstMedia('organizationFilesStatute')->extension}}</a>
    </div>
</x-dynamic-component>
