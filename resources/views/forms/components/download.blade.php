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
    :state-path="$getStatePath()"
>
    <div class="flex flex-wrap gap-2">
        @foreach ($getDownloadItems() as $item)
            <a class="inline-flex items-center gap-x-1.5 rounded-md px-3 py-2 text-sm shadow-sm hover:bg-gray-50 ring-1 ring-inset ring-gray-300 text-gray-900 bg-white truncate"
                href="{{ $item['url'] }}" download="{{ $item['name'] }}" target="_blank">
                <x-heroicon-o-download class="-ml-0.5 h-5 w-5 shrink-0" />

                <span class="overflow-hidden truncate">
                    {{ $item['name'] }}
                </span>
            </a>
        @endforeach
    </div>
</x-dynamic-component>
