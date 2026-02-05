<?php

namespace Modules\Videos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Courses\Models\Course;

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
        'size'
    ];
    protected $attributes = [
        'size' => 0,
    ];
    public function courses() {
        return Video::hasMany(
            Course::class,
            'video_id',
            'id'
        );
    }
}

