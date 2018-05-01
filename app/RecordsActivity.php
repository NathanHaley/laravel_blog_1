<?php

namespace App;

trait RecordsActivity
{

    //Will be triggered as if called in boot of class using this trait
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getRecordableActivities() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
        static::created(function ($model) {
            $model->recordActivity('created');
        });

        static::deleted(function ($model) {
            $model->activity()->delete();
        });
    }

    protected static function getRecordableActivities()
    {
        return static::$recordableActivities ?? [];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event)
        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    /**
     * @param $event
     * @return string
     * @throws \ReflectionException
     */
    protected function getActivityType($event): string
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
}
