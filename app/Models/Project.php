<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
 use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

class Project extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'client',
        'location',
        'area',
        'year',
        'status',
        'featured',
        'published_at',
    ];

    // Slug
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    // العلاقة مع التصنيف
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Collections للصور
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('plans');
    }
   

// public function registerMediaConversions(?Media $media = null): void
// {
//     $this->addMediaConversion('thumb')
//         ->fit(Fit::Crop, 400, 300)
//         ->nonQueued();

//     $this->addMediaConversion('large')
//         ->fit(Fit::Max, 1920, 1080)
//         ->nonQueued();
// }

}
