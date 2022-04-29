<x-admin.layout.app>
    @php
    $breadcrumbs = [
        ['name' => 'Element', 'link' => route("admin.element.index")],
        ['name' => $element->title],
        ['name' => "Banner", "link" => route('LaravelBlock2Banner.index', $element->id)],
        ['name' => "Create"]
    ];
    @endphp
    <x-admin.atoms.breadcrumb :breadcrumbs="$breadcrumbs" />

    <form
        class="relative mt-7"
        method="POST"
        action="{{ route("LaravelBlock2Banner.store", $element->id) }}"
        enctype="multipart/form-data"
    >
        @csrf
        <x-admin.atoms.required />
        <x-admin.atoms.row>
            <x-admin.atoms.label class="required mb-2">
                Image ( {{ $config->img_width }} x {{ $config->img_height }}) (only accept jpg, png)
            </x-admin.atoms.label>
            <input
                type="file"
                name="image"
                id="image"
                class="upload-image-copper"
                data-uic-display-width="{{ $config->img_width }}"
                data-uic-display-height="{{ $config->img_height }}"
                data-uic-target-width="{{ $config->img_width }}"
                data-uic-target-height="{{ $config->img_height }}"
                data-uic-title="Size: {{ $config->img_width }}(w) x {{ $config->img_height }}(h)"
            />
            @error("image")
                <x-admin.atoms.error>
                    {{ $message }}
                </x-admin.atoms.error>
            @enderror
        </x-admin.atoms.row>

        @foreach (config('translatable.locales') as $locale)
            <x-admin.atoms.row>
                <x-admin.atoms.label for="title_{{ $locale }}">
                    Title ({{ $locale }})
                </x-admin.atoms.label>
                <x-admin.atoms.text name="title[{{$locale}}]" id="title_{{$locale}}" />
            </x-admin.atoms.row>
        @endforeach

        <x-admin.atoms.row>
            <div x-data="{isCustomLink: false}">
                <div class="inline-flex items-center mr-4 mb-4">
                    <div class="relative w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="hidden" name="is_custom_link" value="0" />
                        <input
                            type="checkbox"
                            id="is_custom_link"
                            name="is_custom_link"
                            value="1"
                            x-on:click="
                                isCustomLink = !isCustomLink;
                                if(isCustomLink){$('#page_id').val('').trigger('change')};
                                if(!isCustomLink){$('#custom_link').val('')}
                            "
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer focus:outline-none focus:ring-offset-0 focus:ring-transparent" />
                        <label
                            for="is_custom_link"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer">
                        </label>
                    </div>
                    <label for="is_custom_link" class="text-gray-700 cursor-pointer select-none">
                        Custom Link
                    </label>
                </div>

                <div class="inline-flex items-center mr-4 mb-4">
                    <div class="relative w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="hidden" name="is_external" value="0" />
                        <input
                            type="checkbox"
                            id="is_external"
                            name="is_external"
                            value="1"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer focus:outline-none focus:ring-offset-0 focus:ring-transparent" />
                        <label
                            for="is_external"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer">
                        </label>
                    </div>
                    <label for="is_external" class="text-gray-700 cursor-pointer select-none">
                        External Link
                    </label>
                </div>

                <div x-show="isCustomLink">            
                    <x-admin.atoms.text
                        type="text"
                        name="custom_link"
                        id="custom_link"
                    />
                </div>

                <div x-show="!isCustomLink">
                    <label class="inline-block mb-2 cursor-pointer">
                        Link to Page
                    </label>
                    <div class="mt-2">
                        <select name="page_id" id="page_id" class="select2">
                            <option value="" selected>--</option>
                            @foreach ($pages as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->title }} ({{ $item->slug}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </x-admin.atoms.row>

        <hr class="my-10">
        
        <div class="text-right">
            <x-admin.atoms.link
                href="{{ route('LaravelBlock2Banner.index', $element->id) }}"
            >
                Back
            </x-admin.atoms.link>
            <x-admin.atoms.button id="save">
                Save
            </x-admin.atoms.button>
        </div>
    </form>

    @once
        @push('css')
            <link rel="stylesheet" href="{{ asset('css/cropper.css') }}" />
            <link rel="stylesheet" href="{{ asset('css/uploadImageCopper.css') }}" />
            <link rel="stylesheet" href="{{ asset("css/select2.min.css") }}">
        @endpush
        @push('js')
            <script src="{{ asset('js/cropper.min.js') }}"></script>
            <script src="{{ asset('js/uploadImageCopper.js') }}"></script>
            <script src="{{ asset("js/jquery-3.6.0.min.js") }}"></script>
            <script src="{{ asset("js/select2.min.js") }}"></script>
            <script>
                $(".select2").select2();
            </script>
        @endpush
    @endonce
</x-admin.layout.app>
