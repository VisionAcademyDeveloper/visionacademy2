<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{


    protected $fillable = [
        'name', 'university_id', 'department_id', 'description', 'price','logo_url',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
