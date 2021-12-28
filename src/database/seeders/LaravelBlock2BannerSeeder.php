<?php

namespace Database\Seeders;

use App\Models\Element;
use App\Models\ElementTemplate;
use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Page;
use GMJ\LaravelBlock2Banner\Models\Block;
use GMJ\LaravelBlock2Banner\Models\Config;
use Illuminate\Support\Arr;
use Image;

class LaravelBlock2BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = ElementTemplate::where("component", "LaravelBlock2Banner")->first();

        if ($template) {
            return false;
        }

        $template = ElementTemplate::create(
            [
                "title" => "Laravel Block2 Banner ",
                "component" => "LaravelBlock2Banner",
            ]
        );
        $element = Element::create([
            "template_id" => $template->id,
            "title" => "laravel-block2-banner-sample",
            "is_active" => 1
        ]);

        $faker = Factory::create();
        $pages = Page::orderBy("id")->pluck("id")->toArray();
        $config = Config::create([
            "element_id" => $element->id,
            "img_width" => "1920",
            "img_height" => "937",
            "layout" => "text-center",
        ]);

        for ($i = 1; $i < 4; $i++) {
            $title = [];
            $text = [];

            foreach (config('translatable.locales') as $locale) {
                $title[$locale] = $faker->name;
                $text[$locale] = $faker->text(100);
                $link_title[$locale] = $faker->name;
            }

            $collection = Block::create([
                "element_id" => $element->id,
                "title" => $title,
                "text" => $text,
                "display_order" => $i
            ]);

            $img = Image::make(storage_path("demo/food/{$i}.jpg"))->fit($config->img_width, $config->img_height);
            $img->save(storage_path("demo/temp.jpg"));
            $collection->addMedia(storage_path('demo/temp.jpg'))
                ->toMediaCollection("laravel_block2_banner");

            $page_id = Arr::random($pages);

            $collection->link()->create([
                "element_id" => $element->id,
                "page_id" => $page_id,
                "title" => $link_title,
            ]);
        }
    }
}
