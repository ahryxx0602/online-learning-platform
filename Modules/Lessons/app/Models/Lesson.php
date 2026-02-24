<?php

namespace Modules\Lessons\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Courses\Models\Course;
use Modules\Videos\Models\Video;
use Modules\Documents\Models\Document;
// use Modules\Lessons\Database\Factories\LessonFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'lessons';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'video_id',
        'document_id',
        'parent_id',
        'course_id',
        'is_trial',
        'views',
        'position',
        'duration',
        'description',
    ];

    /**
     * Relationship với Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    /**
     * Relationship với Lesson cha (parent)
     */
    public function parent()
    {
        return $this->belongsTo(Lesson::class, 'parent_id', 'id');
    }

    /**
     * Relationship với các Lesson con
     */
    public function children()
    {
        return $this->hasMany(Lesson::class, 'parent_id', 'id');
    }

    public function subLessons()
    {
        return $this->children()->orderBy('position', 'asc')->with('subLessons');
    }

    /**
     * Relationship với Video
     */
    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id', 'id');
    }

    /**
     * Relationship với Document
     */
    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }

    // protected static function newFactory(): LessonFactory
    // {
    //     // return LessonFactory::new();
    // }
}
