<div class="laravel_block2_banner" id="laravel_block2_banner_{{$page_element_id}}">
<div class="gsap-banner">
    <div class="gb-list">
        @foreach ($collection as $item)
            <div class="gb-item gb-item-{{ $loop->index + 1}}" id="gb-item-{{ $loop->index + 1}}">
                @if ($item->elementLinkPage->custom_link)
                    <a href="{{ $item->elementLinkPage->custom_link }}" {{ $item->elementLinkPage->is_external ? "target='_blank'" : ""}}>
                        <img class="gb-img" src="{{ $item->getFirstMedia("laravel_block2_banner")->getUrl() }}" alt="">
                    </a>
                @elseif ($item->elementLinkPage->page_id)
                    <a href="{{ route("frontend.page", $item->elementLinkPage->page->slug) }}">
                        <img class="gb-img" src="{{ $item->getFirstMedia("laravel_block2_banner")->getUrl() }}" alt="">
                    </a>
                @else
                    <img class="gb-img" src="{{ $item->getFirstMedia("laravel_block2_banner")->getUrl() }}" alt="">          
                @endif
                
                @if (!empty($item->getTranslation("title", $locale)))
                    <div class="gb-text">
                        {{ $item->getTranslation("title", $locale) }}
                    </div>    
                @endif
            </div>
        @endforeach
    </div>
    <div class="gb-pagination">
        @foreach ($collection as $item)
        <div class="gb-pagination-item"
            id="gbpi-{{ $loop->index + 1 }}"
            data-slide="{{ $loop->index + 1 }}">
            <div></div>
        </div>
        @endforeach
    </div>
  </div>
</div>

@push('css')
    <style>
        .gsap-banner {
            position: relative;
            overflow: hidden;
        }

        .gb-list {
            width: 100vw;
            height: 100vw;
            background-color: black;
        }

        .gb-list .gb-item {
            position: absolute;
            display: none;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vw;
            background-color: black;
        }

        .gb-list .gb-item::after{
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            width: 100%;
            height: 100%;
            background: -webkit-gradient(linear, left top, left bottom, color-stop(49%, rgba(0, 0, 0, 0)), to(black));
            background: -webkit-linear-gradient(rgba(0, 0, 0, 0) 49%, black);
            background: linear-gradient(rgba(0, 0, 0, 0) 49%, black);
            opacity: 0.4;
        }

        .gsap-banner .gb-item a{
            position: absolute;
            display:block;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index:2;
        }

        .gb-text{
            position: absolute;
            width: 100%;
            left: 50%;
            bottom: 40px;
            padding: 0 25px;
            transform: translateX(-50%);
            font-size: clamp(24px, 5vw, 45px);
            font-weight: 600;
            color: white;
            z-index: 3;
        }

        .gb-list .gb-item .gb-img {
            position: relative;
            vertical-align: top;
            width: auto;
            height: 100%;
            right: 0;
            max-width: unset;
        }

        .gb-pagination {
            position: relative;
            display: flex;
            justify-content: flex-end;
            height: 5px;
            margin-top: 10px;
            margin-right: 10px;
            z-index:3;
        }

        .gb-pagination .gb-pagination-item {
            position: relative;
            width: 40px;
            margin-right: 10px;
            cursor: pointer;
            background-color: rgba(200, 200, 200, 0.4);
        }

        .gb-pagination .gb-pagination-item > div {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background-color: #333;
        }

        @keyframes cssload-width {
            0%,
            100% {
                transition-timing-function: cubic-bezier(1, 0, 0.65, 0.85);
            }
            0% {
                width: 0;
            }
            100% {
                width: 100%;
            }
        }

        @media screen and (min-width: 768px) {
            .gb-text{
                max-width: 66vw;
                bottom: 130px;
            }
            .gsap-banner {
                height: calc(100vh - 44px);
            }
            .gb-list .gb-item {
                width: 100%;
                height: 100%;
            }
            .gb-list .gb-item .gb-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                right: unset;
            }

            .gb-pagination {
                position: absolute;
                justify-content: flex-start;
                padding: 0 25px;
                left: 50%;
                bottom: 65px;
                width: 100%;
                margin: 0;
                max-width: 66vw;
                transform: translateX(-50%);
            }

            .gb-pagination .gb-pagination-item {
                background-color: rgba(255, 255, 255, 0.3);
            }
        }
    </style>
@endpush

@push('js')
    <script>
        gsap.registerPlugin(ScrollTrigger);
        var tween0;
        var tween1;
        var tween2;
        var slide = 1;
        var items = document.querySelectorAll(".gb-pagination-item");
        var imgs = document.querySelectorAll(".gb-img");

        var eventListener = [];

        ScrollTrigger.matchMedia({
        // large
        "(min-width: 768px)": function () {
            if (eventListener.length > 0) {
            resetBannerElement();
            }
            showSlideDesktop(slide);

            items.forEach((item, index) => {
            eventListener[index] = () => {
                if (item.dataset.slide == slide) return false;
                clearElementSetting();
                slide = item.dataset.slide;
                showSlideDesktop();
            };
            item.addEventListener("click", eventListener[index]);
            });

            function showSlideDesktop() {
            document.querySelector(`#gb-item-${slide}`).style.display = "block";
            tween0 = gsap.to(`#gbpi-${slide} > div`, {
                width: "100%",
                duration: 7
            });
            tween1 = gsap.from(`.gb-item-${slide} .gb-img`, {
                opacity: 0,
                scale: 1.1,
                duration: 5
            });
            tween2 = gsap.to(`.gb-item-${slide} .gb-img`, {
                opacity: 0,
                duration: 2,
                delay: 5,
                onComplete: () => {
                document.querySelector(`#gb-item-${slide}`).style.display = "none";
                document.querySelector(`.gb-item-${slide} .gb-img`).style = "";
                document.querySelector(`#gbpi-${slide} > div`).style = "";
                if (slide < items.length) {
                    slide++;
                } else {
                    slide = 1;
                }
                showSlideDesktop();
                }
            });
            }
        },

        // medium
        "(max-width: 769px)": function () {
            if (eventListener.length > 0) {
            resetBannerElement();
            }

            showSlideMobile(slide);

            items.forEach((item, index) => {
            console.log(index);
            eventListener[index] = () => {
                if (item.dataset.slide == slide) return false;
                clearElementSetting();
                slide = item.dataset.slide;
                showSlideMobile();
            };
            item.addEventListener("click", eventListener[index]);
            });

            function showSlideMobile() {
            document.querySelector(`#gb-item-${slide}`).style.display = "block";
            tween0 = gsap.to(`#gbpi-${slide} > div`, {
                width: "100%",
                duration: 13
            });
            tween1 = gsap.to(`.gb-item-${slide} .gb-img`, {
                opacity: 1,
                right: "100%",
                duration: 12
            });
            tween2 = gsap.to(`.gb-item-${slide} .gb-img`, {
                opacity: 0,
                delay: 12,
                duration: 1,
                onComplete: () => {
                document.querySelector(`#gb-item-${slide}`).style.display = "none";
                document.querySelector(`.gb-item-${slide} .gb-img`).style = "";
                document.querySelector(`#gbpi-${slide} > div`).style = "";
                if (slide < items.length) {
                    slide++;
                } else {
                    slide = 1;
                }
                showSlideMobile();
                }
            });
            }
        }
        });

        function resetBannerElement() {
        clearElementSetting();
        items.forEach((item, index) => {
            item.removeEventListener("click", eventListener[index]);
        });
        eventListener = [];
        }

        function clearElementSetting() {
        tween0.pause();
        tween1.pause();
        tween2.pause();

        tween0 = "";
        tween1 = "";
        tween2 = "";

        document.querySelector(`.gb-item-${slide} .gb-img`).style = "";
        document.querySelector(`#gb-item-${slide}`).style.display = "none";
        document.querySelector(`#gbpi-${slide} > div`).style = "";

        imgs.forEach((img) => {
            img.style = "";
        });
        }
    </script>
@endpush