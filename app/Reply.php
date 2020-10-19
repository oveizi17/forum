<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    /*
     * Traits
     */
    use RecordActivity;

    /**
     * Attributes
     */
    protected $guarded = [];
    protected $withCount = ['favorites'];
    protected $with = ['owner'];

    /*
     * Database Relationships
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function makeFavorited()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create([
                'user_id' => auth()->id(),
            ]);
        }
    }
}
