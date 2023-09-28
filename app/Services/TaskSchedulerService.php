<?php
namespace App\Services;

use Illuminate\Support\Facades\Redis;

class TaskSchedulerService{
    public function scheduleTaskDueDate($taskId,$dueDateTime){
        $currentDateTime = now();
        $timeUntilDue = max(0,$dueDateTime->timestamp - $currentDateTime->timestamp);
        
        if($timeUntilDue > 0){
            Redis::setex('task:'.$taskId,$timeUntilDue,'due');

        }
    }
}


