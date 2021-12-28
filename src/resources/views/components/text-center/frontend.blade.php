<div class="laravel_block2_banner" id="laravel_block2_banner_{{$page_element_id}}">
    <div class="swiper" id="laravel_block2_banner_{{$page_element_id}}_swiper">
        <div class="swiper-wrapper">
            @foreach ($collections as $item)
                <div class="swiper-slide">
                    <img src="{{ $item->getMedia("laravel_block2_banner")->first()->getUrl() }}" alt="" class="w-full">
                    <div class="absolute top-0 left-0 w-full h-full z-10 bg-black bg-opacity-50 flex flex-col items-center justify-center">
                        <div class="container mx-auto text-center text-white laravel_block2_banner_text">
                            <h3 class="text-xl md:text-2xl lg:text-4xl">
                                {{ $item->getTranslation("title", $locale) }}
                            </h3>
                            <div class="mt-4">
                                {{ $item->getTranslation("text",  $locale) }}
                            </div>
                            @if ($item->link)
                                <div class="mt-4 text-center">
                                    <a href="{{ route("frontend.page", $item->link->page->slug) }}" class="inline-block px-4 py-1 main-bg-color rounded-md">
                                        {{ $item->link->title ? $item->link->getTranslation("title", $locale) : $item->link->page->title }}
                                    </a> 
                                </div>
                            @endif
                        </div>
                    </div>
                </div>            
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

@push('css')
    <style>
        .laravel_block2_banner img{
            width: 100%;
        }
        .laravel_block2_banner .laravel_block2_banner_text {
            opacity: 0;
            transform: translateY(60px);
            transition: all 0.6s;
            transition-delay: 1s;
        }
        .laravel_block2_banner .swiper-slide-active .laravel_block2_banner_text {
            opacity: 1;
            transform: translateY(0)
        }
    </style>
@endpush

@push('js')
    <script>
        new Swiper("#laravel_block2_banner_{{$page_element_id}}_swiper", {
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            loop:true,
            speed: 1000,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            }
        });
    </script>
@endpush



