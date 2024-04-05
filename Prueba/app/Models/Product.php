<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

 /*    public function user(){
        return $this->hasMany('App/User');
    } */

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
