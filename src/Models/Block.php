<?php

namespace GMJ\LaravelBlock2Banner\Models;

use App\Models\Link;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Block extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected $guarded = [];
    protected $table = "laravel_block2_banners";
    public $translatable = ['title', 'text'];

    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection("laravel_block2_banner")
            ->singleFile();
    }

    public function link()
    {
        return $this->morphOne(Link::class, 'linkable');
    }
}
