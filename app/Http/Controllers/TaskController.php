<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    function get(){
        $tasks = Tasks::all();
        
        return response()->json(['tasks'=>$tasks],200);
    }

    function getOne($id){
        $task = Tasks::find($id);
        return response()->json(['task'=>$task]);
    }

    function add(Request $request){
        $task = new Tasks();
        $task->name = $request->name;
        $task->save();

        return response()->json(['task'=>$task],201);
    }

    function update(Request $request,$id){
        $task = Tasks::find($id);
        $task->task = $request->task;
        $task->status = $request->status;
        $task->save();

        return response()->json(['task'=>$task],204);

        
    }

    function remove($id){
        $task = Tasks::find($id);
        $task->delete();
        return response()->json(['message'=>'task removed successfully'],200);
    }
}
