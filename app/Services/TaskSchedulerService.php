<?php
namespace App\Services;

use App\Events\TaskNotificationEvent;
use App\Models\Tasks;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Event;

class TaskSchedulerService
{
    public function scheduleTaskDueDate($taskId, $dueDateTime)
    {
        $currentDateTime = now();

        // Check if the due date and time are equal to the current time
        if ($dueDateTime->equalTo($currentDateTime)) {
            // Load the task from your database (replace with your task model)
            $task = Tasks::findOrFail($taskId);

            // Trigger an event to send the task to the frontend
            Event::dispatch(new TaskNotificationEvent($task));
        } else {
            // Calculate the time remaining until the due date
            $timeUntilDue = max(0, $dueDateTime->timestamp - $currentDateTime->timestamp);

            // If there's time remaining, schedule the task in Redis
            if ($timeUntilDue > 0) {
                Redis::setex('task:' . $taskId, $timeUntilDue, 'due');
            }
        }
    }
}
