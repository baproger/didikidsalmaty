<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'parent_id', 'slug', 'template', 'status', 'published_at',
        'order', 'show_in_menu', 'blocks',
        'title', 'content', 'excerpt', 'meta_title', 'meta_description',
    ];

    public array $translatable = ['title', 'content', 'excerpt', 'meta_title', 'meta_description'];

    protected $casts = [
        'published_at' => 'datetime',
        'show_in_menu' => 'boolean',
        'blocks'       => 'array',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(fn (\Illuminate\Database\Eloquent\Builder $q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('order');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured')->singleFile()->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(800)->height(500)->nonQueued();
    }
}
