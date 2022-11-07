<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Cart;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cart()
    {
        return $this->belongsToMany(Product::class)->withPivot(
            'id',
            'quantity',
            'checkout_price'
        );
    }

    public function cartTotal() {
        $prices = \DB::select("
            SELECT quantity, product_id, checkout_price, checkout_price*quantity  AS total_price
            FROM product_user
            WHERE user_id = :id", 
            ['id' => $this->id]
        );

        return collect($prices)->sum('total_price');
    }

    public function clearCart() {
        $this->cart()->detach();
    }
}
