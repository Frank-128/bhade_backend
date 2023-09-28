<?php

namespace App\Console;

use App\Events\TaskNotificationEvent;
use App\Models\Tasks;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Redis;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function(){
            $dueTaskKeys = Redis::keys('task:*');
             
            foreach($dueTaskKeys as $taskKey){
                $taskId = substr($taskKey,20);
                $task = Tasks::findOrFail($taskId);
                event(new TaskNotificationEvent($task));
                
                Redis::del($taskKey);

            }

        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
