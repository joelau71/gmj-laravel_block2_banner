<?php

namespace GMJ\LaravelBlock2Banner\Http\Controllers;

use App\Http\Controllers\Controller;
use Alert;
use App\Models\Element;
use GMJ\LaravelBlock2Banner\Models\Config;
use GMJ\LaravelBlock2Banner\Models\Block;

class BlockController extends Controller
{
    public function index($element_id)
    {
        $config = Config::where("element_id", $element_id)->first();
        if (!$config) {
            return redirect()->route("LaravelBlock2Banner.config.create", $element_id);
        }
        $element = Element::findOrFail($element_id);
        $collections = Block::where("element_id", $element_id)->orderBy("display_order")->get();

        return view('LaravelBlock2Banner::index', compact("element_id", "element", "collections"));
    }

    public function create($element_id)
    {
        $element = Element::findOrFail($element_id);
        $config = Config::where("element_id", $element_id)->first();
        return view('LaravelBlock2Banner::create', compact("element_id", "element", "config"));
    }

    public function store($element_id)
    {
        $element = Element::findOrFail($element_id);

        $rules["uic_base64_image"] = "required";
        request()->validate($rules);

        foreach (config("translatable.locales") as $locale) {
            $text[$locale] = request()["text_{$locale}"];
            $title[$locale] = request()["title_{$locale}"];
            $link_title[$locale] = request()["link_title_{$locale}"];
        }

        $display_order = Block::where("element_id", $element_id)->max("display_order");
        $display_order++;

        $collection = Block::create([
            "element_id" => $element_id,
            "title" => $title,
            "text" => $text,
            "display_order" => $display_order
        ]);

        $collection->addMediaFromBase64(request()->uic_base64_image, ["image/jpeg", "image/png"])->toMediaCollection('laravel_block2_banner');

        if (request()->page_id) {
            $collection->link()->create([
                "element_id" => $element->id,
                "page_id" => request()->page_id,
                "title" => $link_title,
            ]);
        }

        $element->active();

        Alert::success("Add Element {$element->title} Banner success");
        return redirect()->back();
    }

    public function edit($element_id, $id)
    {
        $element = Element::findOrFail($element_id);
        $collection = Block::findOrFail($id);
        $config = Config::where("element_id", $element_id)->first();
        return view('LaravelBlock2Banner::edit', compact("element_id", "element", "collection", "config"));
    }

    public function update($element_id, $id)
    {
        $element = Element::findOrFail($element_id);

        foreach (config("translatable.locales") as $locale) {
            $text[$locale] = request()["text_{$locale}"];
            $title[$locale] = request()["title_{$locale}"];
            $link_title[$locale] = request()["link_title_{$locale}"];
        }

        $collection = Block::findOrFail($id);
        $collection->update([
            "title" => $title,
            "text" => $text,
        ]);

        if (request()->uic_base64_image) {
            $collection->addMediaFromBase64(request()->uic_base64_image, ["image/jpeg", "image/png"])->toMediaCollection('laravel_block2_banner');
        }

        $collection->link()->delete();

        if (request()->page_id) {
            $collection->link()->create([
                "element_id" => $element->id,
                "page_id" => request()->page_id,
                "title" => $link_title,
            ]);
        }

        Alert::success("Edit Element {$element->title} Banner success");
        return redirect()->route('LaravelBlock2Banner.index', $element_id);
    }

    public function order($element_id)
    {
        $element = Element::find($element_id);
        $collections =  Block::where("element_id", $element_id)->orderBy("display_order")->get();
        return view("LaravelBlock2Banner::order", compact("element_id", "element", "collections"));
    }

    public function order2($element_id)
    {
        foreach (request()->id as $key => $item) {
            $collection = Block::find($item);
            $num = $key + 1;
            $collection->display_order = $num;
            $collection->save();
        }
        $element = Element::find($element_id);
        Alert::success("Edit Element {$element->title} Banner Order success");
        return redirect()->route('LaravelBlock2Banner.index', $element_id);
    }

    public function destroy($element_id, $id)
    {
        $element = Element::findOrFail($element_id);

        $collection = Block::findOrFail($id);
        $collection->link()->delete();
        $collection->delete();

        if ($collection->count() < 1) {
            $element->inactive();
        }
        Alert::success("Delete Element {$element->title} Banner success");
        return redirect()->route('LaravelBlock2Banner.index', $element_id);
    }
}
