<?php

namespace App;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Channel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'description', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        if($this->media->first()) {
            return $this->media->first()->getFullUrl('thumb');
        }

        return null;
    }

    public function editable()
    {
        if(! auth()->check()) {
            return false;
        }

        return $this->user_id === auth()->user()->id;
    }

    public function registerMediaConversions(Media $media = null) :void
    {
        $this->addMediaConversion('thumb')
            ->fit(\Spatie\Image\Manipulations::FIT_STRETCH, 100, 100);
    }
}
