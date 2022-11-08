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
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate($date)
    {
        return $date->format('m-d-Y H:i:s');
    }

    /**
     * Get the products for this Order.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
