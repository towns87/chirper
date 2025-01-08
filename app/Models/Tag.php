<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function chirps(){
        return this->belongsToMany(Chirp::class);
    }
}
