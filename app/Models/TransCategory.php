<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransCategory extends Model
{
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
