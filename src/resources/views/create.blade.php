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
            @error("uic_base64_image")
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
                <x-admin.atoms.text name="title_{{$locale}}" id="title_{{$locale}}" />
            </x-admin.atoms.row>
        @endforeach

        @foreach (config('translatable.locales') as $locale)
            <x-admin.atoms.row>
                <x-admin.atoms.label for="text_{{ $locale }}">
                    Text ({{ $locale }})
                </x-admin.atoms.label>
                <x-admin.atoms.textarea name="text_{{ $locale }}" id="text_{{ $locale }}"></x-admin.atoms.textarea>
            </x-admin.atoms.row>
            @error("text_{$locale}")
                <x-admin.atoms.error>
                    {{ $message }}
                </x-admin.atoms.error>
            @enderror
        @endforeach

        <x-admin.atoms.row>
            <x-admin.atoms.page can_null />
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
</x-admin.layout.app>
