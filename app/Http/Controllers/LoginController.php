<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    //

    public function login(Request $request){
        $email=$request->email;
        $password=$request->password;
        if(Auth::attempt(['email' => $email, 'password' => $password])){
            $user = Auth()->user();
            $id=Auth()->user()->id;
            $role=Auth()->user()->role;
            $userStatus=Auth()->user()->status;
            $token = $user->createToken("Amber Doctor's Office")->plainTextToken;
            if($role=='staff'){
                if($userStatus=='disabled'){
                    return response()->json([
                        'status'=>'401',
                        'message'=>'User Disabled',
                    ]);
                }
                return response()->json([
                    'status'=>'200',
                    'message'=>'Login Successful',
                    'token'=>$token,
                    'id'=>$id,
                    'userStatus'=>$userStatus,
                    'role'=>$role
                ]);
            }
            if($role=='doctor'){
                return response()->json([
                    'status'=>'200',
                    'message'=>'Login Successful',
                    'token'=>$token,
                    'id'=>$id,
                    'role'=>$role
                ]);
            }
        }

        return response()->json([
            'status'=>'401',
            'message'=>'Login Failed'
        ]);
    }

    public function logout(){
        Auth()->user()->tokens()->delete();

        return response()->json([
            'status'=>'200',
            'message'=>'Logout Successfully'
        ]);
    }
}
