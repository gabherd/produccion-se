<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function getQtyMachineStoped()
    {
        $result = DB::table('machine_stop')
            ->where('hour_end', '=', '00:00')
            ->count();
            
        return $result;
    }

}
