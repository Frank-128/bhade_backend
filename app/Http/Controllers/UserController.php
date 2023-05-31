<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:191',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8|confirmed',
        ]);

        if($validator->fails()){ 
            $errors = $validator->errors();
            return response()->json([
                'status'=>401,
                'message'=>$errors
            ]);
        }else{
            // $user = User::create();
            // return response()->json(["user"=>$user,"status"=>200]);
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return response()->json([
                'status'=>200,
                'message'=>'You are registered'
            ]);

        }
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|string|email|max:255',
            'password'=>'required|string|min:8',

        ]);
        if($validator->fails()){
            $errors = $validator->errors();

            return response()->json([
                "status"=>401,
                "message"=>$errors
            ]);

        }
        else {
           
            $user = $request->validate([
                'email'=>'required|email',
                'password'=>'required'
            ]);
            $validatedUser = Auth::attempt($user);
             if($validatedUser){
                /**@var User $user */
                $user = Auth::user();
                $token = $user->createToken("API Token")->plainTextToken;
               return response()->json(["status"=>200,"token"=>$token]);
             }
             else{
                return response()->json([
                    "status"=>401,
                    "message"=>'Incorrect credentials'
                ]);
    
             }


            
        }
       

    }
   

}
