<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Services\TaskSchedulerService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    protected $taskSchedulerService;

    public function __construct(TaskSchedulerService $taskSchedulerService){
        $this->taskSchedulerService = $taskSchedulerService;
    }
   

    public function get(){
        $tasks = Tasks::all();
        
        return response()->json(['tasks'=>$tasks],200);
    }

    public function getOne($id){
        $task = Tasks::find($id);
        return response()->json(['task'=>$task]);
    }

    public function add(Request $request){
        $task = new Tasks();
        $task->name = $request->name;
        $dateTimeObject = Carbon::parse($request->task_time);
        $task->task_time = $dateTimeObject;
        $task->save();

        $dueDate = $task->task_time;
        $taskId = $task->id;
       
        $this->taskSchedulerService->scheduleTaskDueDate($taskId,$dueDate);

        return response()->json(['task'=>$task],201);
    }

    public function update(Request $request,$id){
        $task = Tasks::find($id);
        
        $task->status = $request->status;
        $task->save();
        // $dueDate = $task->task_time;
        // $taskId = $task->id;

        // $this->taskSchedulerService->scheduleTaskDueDate($taskId,$dueDate);

        return response()->json(['task'=>$task],204);

        
    }

    public function remove($id){
        $task = Tasks::find($id);
        $task->delete();
        return response()->json(['message'=>'task removed successfully'],200);
    }
}
