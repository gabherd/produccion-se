<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        //
    }

    public function getStopMachine(){
        $product = DB::table('machine_stop')
                    ->select('id_machine', 'problem', 'hour_start', 'hour_end', 'id_employee')
                    ->orderBy('hour_start')
                    ->get();

        return $product;
    }

    public function store(Request $request)
    {
        //
    }


    public function show(Home $home)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function destroy(Home $home)
    {
        //
    }
}
