<?php

namespace Modules\Courses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Courses\Database\Factories\CoursesFactory;

class Course extends Model
{
    use HasFactory;

    /**
     *
     * The attributes that are mass assignable.
     */

    protected $table = 'courses';
    protected $fillable = [
        'name',
        'slug',
        'detail',
        'teacher_id',
        'thumbnail',
        'price',
        'sale_price',
        'code',
        'durations',
        'is_document',
        'supports',
        'status',
    ];

    public function teacher()
    {
        return $this->belongsTo(\Modules\User\Models\User::class, 'teacher_id', 'id');
    }

    // protected static function newFactory(): CoursesFactory
    // {
    //     // return CoursesFactory::new();
    // }
}
