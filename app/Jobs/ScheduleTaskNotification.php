<?php

namespace App\Jobs;

use App\Events\TaskNotificationEvent;
use App\Models\Tasks;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ScheduleTaskNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $currentDateTime = now();
        $tasks = Tasks::where('task_time', '=', $currentDateTime)->get();
    
        foreach ($tasks as $task) {
            try {
                event(new TaskNotificationEvent($task));
    
                // Trigger a Pusher event to notify the frontend
                $pusher = new Pusher(config('broadcasting.connections.pusher.key'), config('broadcasting.connections.pusher.secret'), config('broadcasting.connections.pusher.app_id'));
                $pusher->trigger('task-notifications', 'new-task', ['task' => $task]);
            } catch (\Exception $e) {
                Log::error('Error broadcasting task notification: ' . $e->getMessage());
            }
        }
    }
    
}
