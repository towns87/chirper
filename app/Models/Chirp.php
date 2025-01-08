<?php

namespace App\Models;


use App\Events\ChirpCreated;
use Illumintate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Chirp extends Model
{
    protected $fillable = [
        'message'
    ];
    
    protected $dispatchesEvents = [
        'created' => ChirpCreated::class,
    ];


    public function user (): Belongsto
    {
        return $this->belongsTo(User::class);
    }

    public function tags() {
        return this->belongsToMany(Tag::class);
    }
}


