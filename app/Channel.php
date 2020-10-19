<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * Database Relationships
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
