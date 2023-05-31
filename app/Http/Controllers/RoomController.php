<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function add(Request $request){
    $room = new Room;
    $room->roomNo=$request->input('roomNo');
    $room->metreNo=$request->input('metreNo');
    $room->lukuNo=$request->input('lukuNo');
    $room->amount=$request->input('amount');
    $room->save();
    return response()->json(['message'=>'Room successfully added','status'=>200]);
    }
    public function update(Request $request,$id){
        $room = Room::find($id);
        if($room){
            $room->roomNo=$request->input('roomNo');
            $room->metreNo=$request->input('metreNo');
            $room->lukuNo=$request->input('lukuNo');
            $room->amount=$request->input('amount');
            $room->update();
            return response()->json(["status"=>200,"message"=>$room,404]);
        }
        return response()->json(["status"=>404,"message"=>"Room not found"]);
    }
    public function view(){
        $rooms = Room::all();
        if(count($rooms) != 0){
            return response()->json([
                'status'=>200,
                'rooms'=>$rooms,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Rooms Found',
            ]);
        }
    }
    public function viewOne($id){
        $room = Room::find($id);
        if($room){
           return response()->json([
                'status'=>200,
                'room'=>$room,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Room Not Found',
            ]);
        }
    }
}
