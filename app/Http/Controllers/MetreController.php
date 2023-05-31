<?php

namespace App\Http\Controllers;

use App\Models\Metre;
use Illuminate\Http\Request;

class MetreController extends Controller
{
    public function add(Request $request){
       $metre = new Metre();
       $metre->metreNumber = $request->input('metreNumber');
       $metre->roomNumber = $request->input('roomNumber');
       $metre->metreReading = $request->input('metreReading');
       $metre->tenant_id = $request->input('tenant_id');
       $metre->save();

       return response()->json([
        'status'=>200,
        'message'=>'Metre Recordings Added Successfully!'
       ]);
        

    }
    public function update(Request $request, $id){
        $metre = Metre::find($id);
        if($metre){
            
            $metre->metreNumber = $request->input('metreNumber');
            $metre->roomNumber = $request->input('roomNumber');
            $metre->metreReading = $request->input('metreReading');
            $metre->tenant_id = $request->input('tenant_id');
            $metre->update();
            
            return response()->json([
                'status'=>200,
                'message'=>$metre,
               ]);
        } else{

            return response()->json([
                'status'=>404,
                'message'=>"Metre not found",
               ]);
        }
    }
    public function view(){
        $metre = Metre::all();
        if(count($metre) != 0){
            return response()->json([
                'status'=>200,
                'metre'=>$metre,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No metre Found',
            ]);
        }
    }
    public function viewOne($id){
        $metre = Metre::find($id);
        if($metre){
           return response()->json([
                'status'=>200,
                'metre'=>$metre,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Metre Not Found',
            ]);
        }
    }

    
}
