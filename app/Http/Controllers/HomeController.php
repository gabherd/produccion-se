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
                    ->select('id','machine_stop.id_machine', 'name_step as description', 'problem', 'hour_start', 'hour_end', 'name', 'employee.id_employee as employee')
                    ->join('employee', 'employee.id_employee', '=', 'machine_stop.id_employee')
                    ->join('machine', 'machine.id_machine', '=', 'machine_stop.id_machine')
                    ->orderBy('hour_start')
                    ->get();

        return $product;
    }

    public function getEmployee(){
        $product = DB::table('employee')
                    ->select('id_employee as id','name', 'position')
                    ->orderBy('id_employee')
                    ->get();

        return $product;
    }

    public function getMachine(){
        $product = DB::table('machine')
                    ->select('id_machine as id','number_step', 'name_step as name')
                    ->orderBy('id_machine')
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

    public function storeEmployee(Request $request)
    {
        $request = DB::table('employee')
                    ->insert([
                        'id_employee' => $request['number-employee'],
                        'name' => $request['name'],
                        'position' => $request['position'],
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
