<?php


namespace App;


trait RecordActivity
{
    /*
     * Attributes
     */
    protected static $activitiesToRecord = ['created'];

    /*
     * Database Relationships
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /*
     * Booted method
     */
    public static function bootRecordActivity()
    {
        if(auth()->guest()) return;

        foreach (static::$activitiesToRecord as $event) {

            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }


    /*
     * Method that record any activity from any model which uses this trait
     */
    public function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    /*
     * Helper methods
     */

    public function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }
}
