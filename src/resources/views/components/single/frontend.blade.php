<div class="laravel_block2_banner_single" id="laravel_block2_banner_single_{{$page_element_id}}">
    <div class="relative overflow-hidden">
        <img class="w-full relative left-1/2 -translate-x-1/2" style="min-width: 1536px;" src="{{ $collection->getFirstMedia("laravel_block2_banner")->getUrl() }}" alt="">
        @if ($collection->title)
            <div class="absolute w-full bg-black bg-opacity-60 text-white top-1/2 -translate-y-1/2 text-center py-2 text-4xl">
                {{ $collection->title }}
            </div>
        @endif
    </div>
</div>
