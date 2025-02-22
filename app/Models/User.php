<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function codes() {
        return $this-> hasMany(VerificationCode::class,'user_id');
    }

    public function wishlist() {
        return $this-> belongsToMany(Product::class,'wishlists')->withTimestamps();
    }

    public function wishlistHas($product_id) {
        return self::wishlist()->where('product_id', $product_id)->exists();
    }
}
