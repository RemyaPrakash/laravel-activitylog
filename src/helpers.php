<?php

use Spatie\Activitylog\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

if (! function_exists('activity')) {
    function activity(string $logName = null): ActivityLogger
    {
        $defaultLogName = config('activitylog.default_log_name');

        return app(ActivityLogger::class)->useLog($logName ?? $defaultLogName);
    }
}

function logActivity(int $logEventTypeID ,  Model $model , string $eventName = "" ) {
    $defaultLogName = config('activitylog.default_log_name');
    $batchID = rand();
    return app(ActivityLogger::class)
                    ->useLog($logName ?? $defaultLogName)
                    ->performedOn($model)
                    ->withProperties($model->attributeValuesToBeLogged($eventName))
                    ->withBatchID($batchID)
                    ->withEventID($logEventTypeID)
                    ->withManuallyAdded(1)
                    ->log();
}
