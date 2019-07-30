<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','course_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
