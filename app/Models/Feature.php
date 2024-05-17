<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function creator(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approved(){
        return $this->belongsTo(User::class, 'user_approved_id');
    }

}
