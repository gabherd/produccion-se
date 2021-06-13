<?php

namespace App\Http\Controllers;

use \Datetime;
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
                    ->select('id','id_machine', 'problem', 'hour_start', 'hour_end', 'id_employee')
                    ->orderBy('hour_start')
                    ->get();

        return $product;
    }

    public function store(Request $request)
    {
        $now = new DateTime();

        $request = DB::table('machine_stop')
                    ->insert([
                        'problem' => $request['problem'],
                        'hour_start' => $request['hour_start'],
                        'hour_end' => $request['hour_end'],
                        'date' => $now->format('Y-m-d H:i:s'),
                        'id_employee' => $request['employee'],
                        'id_machine' => 'CA-'.$request['machine']
                    ]);

        if($request){
            $response = array('status'=>1, 'msg'=>'Created successfully');
        }else{
            $response = array('status'=>'error', 'msg'=>'Data not creacted');
        }
        
        return Response()->json($response);  
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
    public function destroy($id)
    {
        $query = DB::table('machine_stop')->where('id', $id)->delete(); 

        if($query){
            $response = array('status' => 1, 'msg'=>'Deleted');
        }else{
            $response = array('status' => 0, 'msg'=>'Data not deleted');
        }
        
        return Response()->json($response);  
    }
}
