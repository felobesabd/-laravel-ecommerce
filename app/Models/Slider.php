<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'slider';
    protected $fillable = ['photo', 'created_at', 'updated_at'];

    public function getPhotoAttribute($val)
    {
        return ($val !== null) ? asset('assets/images/slider/'.$val) : '';
    }
}
