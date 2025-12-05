<?php

namespace Modules\Videos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'url',
    ];
}

