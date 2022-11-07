<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Product;


class Order extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    /**
     * Get the comments for the blog post.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
