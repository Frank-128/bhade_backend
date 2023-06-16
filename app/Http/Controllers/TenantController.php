<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    public function add(Request $request){

       $tenantDetails = new Tenant();
       $tenantDetails->firstname=$request->input('firstname');
       $tenantDetails->lastname=$request->input('lastname');
       $tenantDetails->phoneNumber=$request->input('phoneNo');
       $tenantDetails->amountPaid=$request->input('amountPaid');
       $tenantDetails->startDate=$request->input('startDate');
       $tenantDetails->endDate=$request->input('endDate');
       $tenantDetails->roomNo=$request->input('roomNo');
       $tenantDetails->currMetreReading=$request->input('metre');

       
            
       if($request->hasFile('contract')){
        $path = $request->file('contract')->store('files');
        $tenantDetails->contract = $path;
   }
       

       $tenantDetails->save();

        if($tenantDetails){
            return response()->json([
                'status'=>200,
                'message'=>'Tenant Added Successfully!'
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'Add Tenant Failed!'
            ]);
        }

       
    }
    public function getOne($id){
        $tenant= Tenant::find($id);
        if($tenant){
            return response()->json([
                'status'=>200,
                'tenant'=>$tenant
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Tenant Not Found'
            ]);
        }
    }
    public function getAll(){
        $tenants= Tenant::all();
        if(count($tenants) != 0){
            return response()->json([
                'status'=>200,
                'tenants'=>$tenants
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Tenants Not Found'
            ]);
        }
    }
    public function updateTenant(Request $request, $id){
        $availTenant = Tenant::find($id);
        if($availTenant){
         $availTenant->firstname = $request->input('firstname');
         $availTenant->lastname = $request->input('lastname');
         $availTenant->phoneNumber = $request->input('phoneNo');
         $availTenant->contract = $request->input('contract');
         $availTenant->startDate = $request->input('startDate');
         $availTenant->endDate = $request->input('endDate');
         $availTenant->currMetreReading = $request->input('metre');
         $availTenant->amountPaid = $request->input('amountPaid');
        
         if($request->hasFile('contract')){
            $path = $request->file('contract')->store('public/files');
            $$availTenant->contract = $path;
       }
         $availTenant->update();

         return response()->json([
            'status'=>200,
            'availTenant'=>$availTenant,
        ]);
         
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Tenant Not Updated!'
            ]);
        }
    }
    
}
