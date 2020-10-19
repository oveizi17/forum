<?php

namespace App;

use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    /*
     * Traits
     */
    use RecordActivity;
    /**
     * Attributes
     */
    protected $guarded = [];

    protected $withCount = ['replies'];
    protected $with = ['creator', 'channel'];


    /**
    /*
     * Database Relationships
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);

    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Helper Methods
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    /*
     * Query Builder
     */

    public function scopeFilter($query,ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    public function remove(User $user)
    {
        if($this->user_id != $user->id) {
            abort(403, 'You are not allowed to performe this request');
        } else {
            $this->delete();
        }
    }


}
