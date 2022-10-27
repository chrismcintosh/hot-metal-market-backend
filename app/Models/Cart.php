<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;



class Cart extends Pivot
{
    protected $table = 'product_user';
    public $incrementing = true;

    public function user()
    {
        return $this->belongsToMany(User::class, 'product_user', 'product_id', 'user_id');
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_user', 'product_id', 'user_id');
    }
}
