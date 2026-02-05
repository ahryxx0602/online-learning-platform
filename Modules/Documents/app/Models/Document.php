<?php

namespace Modules\Documents\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Courses\Models\Course;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

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
        return Document::hasMany(
            Course::class,
            'document_id',
            'id'
        );
    }
}

