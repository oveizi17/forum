<?php


namespace App\Filters;


use App\Thread;
use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];

    public function by($username)
    {
        $userId = User::whereName($username)->firstOrFail()->id;


        return $this->builder->where('user_id', $userId);
    }

    public function popular()
    {
        return $this->builder->orderBy('replies_count', 'desc');
    }
}
