<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'product_images';
    protected $fillable = ['product_id', 'photo', 'created_at', 'updated_at'];

    public function getPhotoAttribute($val)
    {
        return ($val !== null) ? asset('assets/images/product/'.$val) : '';
    }
}
