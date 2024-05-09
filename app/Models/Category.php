<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    protected $fillable = ['parent_id', 'slug', 'is_active'];
    protected $with = ['translations'];
    protected $hidden = ['translations'];
    protected $casts = ['is_active' => 'boolean'];
    protected $translatedAttributes = ['name'];
    public $timestamps = false;

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function getActive()
    {
        return $this->is_active == 0 ? __('dashboard.not_active') : __('dashboard.active');
    }
}
