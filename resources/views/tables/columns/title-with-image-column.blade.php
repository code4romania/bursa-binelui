<div
    {{ $attributes->merge($getExtraAttributes())->class([
        'flex items-start gap-4',
        'px-4 py-3' => !$isInline(),
        match ($getSize()) {
            'sm' => 'text-sm',
            'lg' => 'text-lg',
            default => null,
        },
        match ($getWeight()) {
            'thin' => 'font-thin',
            'extralight' => 'font-extralight',
            'light' => 'font-light',
            'medium' => 'font-medium',
            'semibold' => 'font-semibold',
            'bold' => 'font-bold',
            'extrabold' => 'font-extrabold',
            'black' => 'font-black',
            default => null,
        },
        match ($getFontFamily()) {
            'sans' => 'font-sans',
            'serif' => 'font-serif',
            'mono' => 'font-mono',
            default => null,
        },
    ]) }}>
    <div class="w-10 h-10 overflow-hidden bg-gray-100 rounded-full">
        @if (null !== ($image = $getImage()))
            <img class="inline-block w-10 h-10" src="{{ $image }}" alt="">
        @endif
    </div>

    <div>
        <span class="block">
            {{ $getState() }}
        </span>
        <span class="block">
            {{ $getOrganization() }}
        </span>

        <span class="block text-xs text-gray-500 empty:hidden">
            {{ $getDescription() }}
        </span>
    </div>
</div>
