<?php

namespace GMJ\LaravelBlock2Banner\Http\Controllers;

use App\Http\Controllers\Controller;
use GMJ\LaravelBlock2Banner\Models\LaravelBlock2Banner;
use Alert;
use App\Models\Element;
use GMJ\LaravelBlock2Banner\Models\Config;

class ConfigController extends Controller
{

    public function create($element_id)
    {
        $element = Element::findOrFail($element_id);
        return view('LaravelBlock2Banner.config::create', compact("element_id", "element"));
    }

    public function store($element_id)
    {
        $element = Element::findOrFail($element_id);

        request()->validate([
            "img_width" => ["required", "integer"],
            "img_height" => ["required", "integer"],
            "layout" => ["required"],
        ]);

        Config::create([
            "element_id" => $element_id,
            "img_width" => request()->img_width,
            "img_height" => request()->img_height,
            "layout" => request()->layout,
        ]);

        Alert::success("Add Element {$element->title} Banner Config success");
        return redirect()->route('LaravelBlock2Banner.index', $element_id);
    }

    public function edit($element_id)
    {
        $element = Element::findOrFail($element_id);
        $collection = Config::where("element_id", $element_id)->first();
        return view('LaravelBlock2Banner.config::edit', compact("element_id", "element", "collection"));
    }

    public function update($element_id)
    {
        $element = Element::findOrFail($element_id);

        request()->validate([
            "img_width" => ["required", "integer"],
            "img_height" => ["required", "integer"],
            "layout" => ["required"],
        ]);

        $colleciton = Config::where("element_id", $element_id)->first();

        $colleciton->update([
            "img_width" => request()->img_width,
            "img_height" => request()->img_height,
            "layout" => request()->layout,
        ]);

        Alert::success("Edit Element {$element->title} Banner Config success");
        return redirect()->route('LaravelBlock2Banner.index', $element_id);
    }
}
