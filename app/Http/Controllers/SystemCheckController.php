<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemCheckController extends Controller
{
    //
    public function systemStatus(){
        return response()->json([
            'status'=>'200',
            'message'=>'System is Up'
        ]);
    }
}
