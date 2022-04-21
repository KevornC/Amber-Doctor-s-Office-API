<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Visitors;
use Illuminate\Contracts\Support\Jsonable;
use Carbon\Carbon;

class DoctorController extends Controller
{
    //
    public function dashboard(){

        $todaysDate = carbon::now();

        $todaysDate = $todaysDate->toDateString();

        $appointmentsForToday = Visitors::where('appointmentDate',$todaysDate)->get();
        
        $totalNOStaff = User::where('role','staff')->where('status','newlyOpened')->count();
        $totalActiveStaff = User::where('role','staff')->where('status','Active')->count();
        $totalDisabledStaff = User::where('role','staff')->where('status','disabled')->count();
        $totalAppointments = Visitors::count();

        return response()->json([
            'status'=>'200',
            'message'=>'Retreived Successfully',
            'appointmentsForToday'=>$appointmentsForToday,
            'totalNewlyOpenedStaff'=>$totalNOStaff,
            'totalActiveStaff'=>$totalActiveStaff,
            'totalDisabledStaff'=>$totalDisabledStaff,
            'totalAppointments'=>$totalAppointments
        ]);
    }    
    public function editAppointment($id){
        $Appointment = Visitors::find($id);

        return response()->json([
            'status'=>'200',
            'message'=>'Retreived Successfully',
            'appointment'=>$Appointment
        ]);
    }

    public function updateAppointment(Request $request ,$userID,$id){

        $staff=User::find($userID);

        Visitors::find($id)->update([
            'firstName'=>$request->firstName,
            'lastName'=>$request->lastName,
            'tel'=>$request->phoneNumber,
            'appointmentDate'=>$request->appointmentDate,
            'time'=>$request->time,
            'subject'=>$request->subject,
            'reason'=>$request->reason,
            'changedStatus'=>$staff->name,
            'EditBy'=>$staff->name
        ]);

        return response()->json([
            'status'=>'200',
            'message'=>'Updated Successfully',
        ]);
    }

    public function index(){
        $staff = User::where('role','staff')->paginate('5');

        return response()->json([
            'status'=>'200',
            'message'=>'Staff Retrieval Successfull',
            'staff'=>$staff
        ]);
    }
    public function store(Request $request){
        $count = User::where('email',$request->email)->count();
        if($count==0){
            User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->email)
            ]);
    
            return response()->json([
                'status'=>'201',
                'message'=>'Staff Created Successfully',
            ]);
        }
        return response()->json([
            'status'=>'200',
            'message'=>'Duplicate Entry',
        ]);
    }
    public function edit($id){
        $staff = User::find($id);
    
        return response()->json([
            'status'=>'200',
            'message'=>'Staff Retrieved Successfully',
            'staff'=>$staff
        ]);
    }
    public function update(Request $request,$id){
        User::find($id)->update([
            'name'=>$request->name,
            'email'=>$request->email
        ]);

        return response()->json([
            'status'=>'200',
            'message'=>'Staff Updated Successfully',
        ]);

    }
    public function disable($id){

        User::find($id)->update(['status'=>'disabled']);

        return response()->json([
            'status'=>'201',
            'message'=>'Staff Disabled Successfully',
        ]);
    }
    public function enable($id){

        User::find($id)->update(['status'=>'Active']);

        return response()->json([
            'status'=>'201',
            'message'=>'Staff Enabled Successfully',
        ]);
    }
    public function updatePassword($id){
        $staff = User::find($id);
        User::find($id)->update([
            'password'=>bcrypt($staff->email),
            'status'=>'Password Changed'
        ]);

        return response()->json([
            'status'=>'200',
            'message'=>'Updated Successfully',
        ]);
    }
    
    public function search($email){
        $result=User::where('email',$email)->get();
        return response()->json([
            'status'=>'200',
            'message'=>'Updated Successfully',
            'result'=>$result
        ]);
    }
}
