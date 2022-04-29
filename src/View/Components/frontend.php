<?php

namespace GMJ\LaravelBlock2Banner\View\Components;

use App\Traits\LocaleTrait;
use GMJ\LaravelBlock2Banner\Models\Block;
use GMJ\LaravelBlock2Banner\Models\Config;
use Illuminate\View\Component;

class Frontend extends Component
{
    use LocaleTrait;
    public $element_id;
    public $page_element_id;
    public $collection;
    public $locale;

    public function __construct($pageElementId, $elementId)
    {
        $this->page_element_id = $pageElementId;
        $this->element_id = $elementId;
        $this->collection = Block::with("media")->where("element_id", $elementId)->orderBy("display_order")->get();
        $this->locale = $this->getLocale();
    }

    public function render()
    {
        $config = Config::where("element_id", $this->element_id)->first();
        $layout = $config->layout;
        if ($layout === "single") {
            $this->collection = Block::with("media")->where("element_id", $this->element_id)->orderBy("display_order")->first();
        }
        return view("LaravelBlock2Banner::components.{$layout}.frontend");
    }
}
