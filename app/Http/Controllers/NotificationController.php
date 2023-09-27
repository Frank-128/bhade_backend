<!-- <?php

// namespace App\Http\Controllers;

// use App\Models\Tasks;
// use Illuminate\Http\Request;
// use Pusher\Pusher;


// class NotificationController extends Controller
// {
//     //
//     public function sendTaskNotification(Tasks $task)
// {
//     $pusher = new Pusher(
//         config('pusher.app_id'),
//         config('pusher.app_key'),
//         config('pusher.app_secret'),
//         config('pusher.cluster'),
//     );

//     $channel = 'notifications.' . $task->user->id;

//     $pusher->trigger($channel, 'task-notification', [
//         'task_id' => $task->id,
//     ]);
// }
// }

