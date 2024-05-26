<?php

namespace App\Traits;

use App\Models\AppLog;

trait GenerateAppLog
{
    protected static function bootGenerateAppLog()
    {
        foreach (static::getEventsToLog() as $eventName) {
            static::$eventName(function ($model) use ($eventName) {
                return AppLog::create([
                    'model' => get_class($model),
                    'model_id' => $model->attributes[$model->primaryKey] ? $model->attributes[$model->primaryKey] : null,
                    'operation' => static::getActionName($eventName),
                    'data' => static::getOldData($eventName, $model),
                    'ip_address' => request()->ip(),
                    'username' => auth()->user() ? auth()->user()->username : null,
                ]);
            });
        }
    }

    protected static function getEventsToLog()
    {
        if (isset(static::$recordEvents)) {
            return static::$recordEvents;
        }
        return ['created', 'updated', 'deleted',];
    }

    protected static function getActionName($eventName)
    {
        switch ($eventName) {
            case 'created':
                return 'CREATE';
            case 'updated':
                return 'UPDATE';
            case 'deleted':
                return 'DELETE';
            default:
                return 'UNKNOWN';
        }
    }

    protected static function getOldData($eventName, $model)
    {
        switch ($eventName) {
            case 'created':
                return null;
            case 'updated':
                return json_encode($model->getOriginal());
            case 'deleted':
                return null;
            default:
                return null;
        }
    }
}
