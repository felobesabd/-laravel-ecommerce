<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    public $table = 'verification_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'code', 'created_at', 'updated_at'];


    public function userCode() {
        return $this-> belongsTo(User::class,'user_id');
    }
}
