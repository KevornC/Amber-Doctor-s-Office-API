<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Visitors;
class VisitorsController extends Controller
{
    //
    public function setAppointment(Request $request){

        $check = Visitors::all();

        if(sizeof($check)==0){
            Visitors::create([
                'firstName'=>$request->firstName,
                'lastName'=>$request->lastName,
                'tel'=>$request->phoneNumber,
                'appointmentDate'=>$request->appointmentDate,
                'time'=>$request->time,
                'subject'=>$request->subject,
                'reason'=>$request->reason,
            ]);
            return response()->json([
                'status'=>'201',
                'message'=>'Appointment Set Successfully',
            ]);
        }
        
        $search = Visitors::where('appointmentDate',$request->appointmentDate)->where('time',$request->time)->count();
        if($search<=0){
            Visitors::create([
                'firstName'=>$request->firstName,
                'lastName'=>$request->lastName,
                'tel'=>$request->phoneNumber,
                'appointmentDate'=>$request->appointmentDate,
                'time'=>$request->time,
                'subject'=>$request->subject,
                'reason'=>$request->reason,
            ]);
    
            return response()->json([
                'status'=>'201',
                'message'=>'Appointment Set Successfully',
            ]);
        }

        return response()->json([
            'status'=>'200',
            'message'=>'Setting Appointment Failed',
        ]);
    }
}
