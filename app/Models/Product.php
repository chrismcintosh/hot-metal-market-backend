<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\User;


class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    protected $appends = ['cmedia'];
    
    public function order()
    {
        return $this->belongsToMany(Order::class);
    }

    // public function cmedia()
    // {
    //     $media = $this->getMedia();
    //     return $media->map(function ($item) {
    //         return $item->getUrl();
    //     })->toArray();
    // }

    public function cmedia(): Attribute
    {
        $media = $this->getMedia();
        return Attribute::make(
            get: fn () => $media->map(function ($item) {
                return $item->getUrl();
            })->toArray(),
        );
    }

    public function carts()
    {
        return $this->belongsToMany(User::class);
    }
    
}
