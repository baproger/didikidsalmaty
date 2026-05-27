<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Teacher extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations;

    protected $fillable = ['name', 'position', 'bio', 'education', 'experience', 'subjects', 'order', 'is_active'];

    public array $translatable = ['name', 'position', 'bio', 'education', 'experience', 'subjects'];

    protected $casts = ['is_active' => 'boolean'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile()->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)->height(400)->nonQueued();
    }
}
