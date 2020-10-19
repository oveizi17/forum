<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    /*
     * Database Relationship
     */
    public function subject()
    {
        return $this->morphTo();
    }


    public static function feed(User $user)
    {
        return $user->activities()
            ->latest()
            ->with('subject')
            ->get()
            ->groupBy(function ($activity){
                return $activity->created_at->format('d-M-Y');
            });
    }

}
