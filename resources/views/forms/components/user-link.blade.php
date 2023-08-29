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
    :state-path="$getStatePath()">
    <div class="flex flex-wrap gap-2">
        @foreach ($getUsers() as $user)
            <a
                class="inline-flex items-center gap-x-1.5 rounded-md px-3 py-2 text-sm shadow-sm hover:bg-gray-50 ring-1 ring-inset ring-gray-300 text-gray-900 bg-white truncate"
                href="{{ $user['url'] }}">
                <span class="overflow-hidden truncate">
                    {{ $user['name'] }}
                </span>

                <x-heroicon-o-external-link class="-mr-0.5 h-4 w-4 shrink-0" />
            </a>
        @endforeach
    </div>
</x-dynamic-component>
