<?php

namespace Modules\Courses\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Categories\Models\Category;
use Modules\Teachers\Models\Teacher;

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

    protected $with = ['teacher'];

    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');    
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'categories_courses',
            'courses_id',      // tên khoá ngoại ĐANG CÓ trong bảng pivot
            'category_id'
        );
    }
}
