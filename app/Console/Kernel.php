<?php

namespace App\Console;

use App\Events\TaskNotificationEvent;
use App\Models\Tasks;
use Carbon\Carbon;
use Hamcrest\Core\IsSame;
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
        $schedule->call(function () {
            $dueTaskKeys = Redis::keys('task:*');

            foreach ($dueTaskKeys as $taskKey) {
                $taskId = substr($taskKey, 20);
                $currentDateTime = Carbon::now('Africa/Dar_es_Salaam');
                $task = Tasks::findOrFail($taskId);
                $dueTime = Carbon::parse($task->task_time,'Africa/Dar_es_Salaam');
                echo "due time is".$dueTime->format('Y-m-d H:i')."\n";
                echo "current time is".$currentDateTime->format('Y-m-d H:i')."\n";
                echo ($dueTime->format('Y-m-d H:i') === $currentDateTime->format('Y-m-d H:i'))?"true":"false";
                if (!$task->status && $dueTime->format('Y-m-d H:i') === $currentDateTime->format('Y-m-d H:i')) {
                    echo "we are here arent we";
                    $task->update(['status' => true]);
                    event(new TaskNotificationEvent($task));
                }
                Redis::del($taskKey);
            }
        })->everyMinute();
    }
  
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
