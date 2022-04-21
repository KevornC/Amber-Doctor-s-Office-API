<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Visitors;

class UserController extends Controller
{
    //
    public function resetPassword($email){
        $searchRecord = User::where('email',$email)->count();

        if($searchRecord==1){
            $search = User::where('email',$email)->get('id');
            foreach ($search as $value) {
                $id=$value;
            }

            return response()->json([
                'status'=>'200',
                'message'=>'Search Successfully',
                'record'=>$id,
            ]);

        }

        return response()->json([
            'status'=>'200',
            'message'=>'Search Failed',
        ]);
    }

    public function updatePassword(Request $request){
        User::find($request->id)->update([
            'password'=>bcrypt($request->password),
            'status'=>'Active'
        ]);

        return response()->json([
            'status'=>'200',
            'message'=>'Updated Successfully',
        ]);
    }
    public function updateStatus(Request $request){
        $staff = User::find($request->userID);

        Visitors::find($request->id)->update([
            'status'=>$request->status,
            'changedStatus'=>$staff->name,
        ]);

        return response()->json([
            'status'=>'200',
            'message'=>'Updated Successfully',
        ]);
    }
    public function searchAppointment($search){

        $appointmentSearchedFor = Visitors::where('tel',$search)->get();

        return response()->json([
            'status'=>'200',
            'message'=>'Updated Successfully',
            'appointmentSearchedFor'=>$appointmentSearchedFor
        ]);
    }

    public function staffCheck($id){
        $staff=User::find($id);

        if($staff->status=='disabled'){
            return response()->json([
                'status'=>'200',
                'message'=>'User Disabled',
            ]);
        }
        return response()->json([
            'status'=>'200',
            'message'=>'User Active',
        ]);
    }

    
    public function allAppointments(){

        $appointments = Visitors::get();
        $totalAppointments = Visitors::count();

        return response()->json([
            'status'=>'200',
            'message'=>'Retreived Successfully',
            'allAppointments'=>$appointments,
            'totalAppointments'=>$totalAppointments
        ]);
    }

    
}
