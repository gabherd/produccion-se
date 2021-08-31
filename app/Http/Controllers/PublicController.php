<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicController extends Controller
{
    public function changeDate($date){

        $validated =  Validator::make(['test' => $date],
            ['test' => 'date_format:Y-m-d']
        );

        if ($validated->fails()) {
            return 'Error date format';
        }else{
            session(['customDate'=> $date]);

            return Response()->json(['status'=>200, 'msg'=>'Success']);
        }

    }
}
