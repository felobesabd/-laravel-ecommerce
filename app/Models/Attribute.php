<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use Translatable;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function attrOptions()
    {
        return $this->hasMany(AttrOption::class, 'attribute_id');
    }
}
