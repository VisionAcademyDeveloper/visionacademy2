<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{


    protected $guarded = [];

    //scopes



    //relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
