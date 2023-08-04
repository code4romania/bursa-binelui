<div class="flex ml-4">
        <div class="flex items-start">
            @if($getRecord()->cover_image !='')
            <div >
                <img class="inline-block h-16 w-16 rounded-full" src="{{$getRecord()->cover_image}}" alt="">
            </div>
            @endif
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{$getRecord()->name}}</p>
                <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700">{{__('field.updated_at')}}{{$getRecord()->updated_at}}</p>
            </div>
        </div>
</div>
