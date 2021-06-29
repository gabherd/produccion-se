<?php

namespace App\Http\Controllers;

use \Datetime;
use App\Models\Home;
use App\Models\MachineStop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MachineStopController extends Controller
{
    public function index()
    {
        //
    }

    public function getStopMachine(){
        $now = new DateTime();

        $product = MachineStop::select('id',
                                    'machine_stop.id_machine', 
                                    'name_step as description', 
                                    'problem', 
                                    'updated_at AS updated',
                                    'employee.id_employee',
                                    'position.id_position',
                                    DB::raw('IFNULL(name_employee, name_position) as responsible'),
                                    DB::raw('DATE_FORMAT(hour_start, "%H:%i") AS hour_start'),
                                    DB::raw('(CASE WHEN DATE_FORMAT(hour_end, "%H:%i") = "00:00" THEN "00:00" ELSE DATE_FORMAT(hour_end, "%H:%i") END) AS hour_end'))
                                ->join('machine', 'machine.id_machine', '=', 'machine_stop.id_machine')
                                ->leftjoin('employee', 'employee.id_employee', '=', 'machine_stop.id_employee')
                                ->leftjoin('position', 'position.id_position', '=', 'machine_stop.id_position')
                                ->orderBy('updated_at', 'DESC')
                                ->where('updated_at', '>=', date('2021-06-18'))
                                ->get();

        return $product;
    }

    public function getEmployee(){
        $product = DB::table('employee')
                    ->select('id_employee as id','name_employee as name', 'position')
                    ->orderBy('id_employee')
                    ->get();

        return $product;
    }

    public function getMachine(){
        $product = DB::table('machine')->select('id_machine as id','number_step', 'name_step as name')
                                ->orderBy('id_machine')
                                ->get();

        return $product;
    }

    public function store(Request $request)
    {
        $now = new DateTime();
        //check-switch
        
        if ($request['hour_end'] == null) {
            $hour_end = '00:00:00';
        }else{
            $hour_end = $request['hour_end'];
        }

        if ($request['swt-employee'] == 'on') {
            $request = MachineStop::insert([
                'problem' => $request['problem'],
                'hour_start' => $request['hour_start'],
                'hour_end' => $hour_end,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'id_employee' => $request['employee'],
                'id_machine' => 'CA-'.$request['machine']
            ]);
        }else if ($request['position'] != null) {
            $request = MachineStop::insert([
                'problem' => $request['problem'],
                'hour_start' => $request['hour_start'],
                'hour_end' => $hour_end,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'id_position' => $request['position'],
                'id_machine' => 'CA-'.$request['machine']
            ]);
        }else{
           return Response()->json(['status'=>500, 'msg'=>'Data not creacted']);
        }


        if($request){
            $response = array('status'=>1, 'msg'=>'Created successfully');
        }else{
            $response = array('status'=>500, 'msg'=>'Data not creacted');
        }
        
        return Response()->json($response);  
    }

    public function storeEmployee(Request $request)
    {
        $request = DB::table('employee')->insert([
                                    'id_employee' => $request['number-employee'],
                                    'name_employee' => $request['name'],
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

    public function update(Request $request, $id)
    {

        try{
            $stop = MachineStop::find($id);

            $stop->id_machine = 'CA-'.$request['machine'];
            $stop->problem = $request['problem'];
            $stop->hour_start = $request['hour_start'];
            $stop->hour_end = $request['hour_end'];

            if ($request['swt-employee'] == 'on') {
                $stop->id_employee = $request['employee'];
                $stop->id_position = null;
            }else{
                $stop->id_employee = null;
                $stop->id_position = $request['position'];
            }

            $stop->save();

            return response()->json(["status" => 200, "detail" => "Updated successful "]); 

        }catch(Exception $e){

            return response()->json(["status" => 500, "detail" => "Data not updated"]); 

        }

    }

    public function destroy($id)
    {
        $query = MachineStop::where('id', $id)->delete(); 

        if($query){
            $response = array('status' => 1, 'msg'=>'Deleted');
        }else{
            $response = array('status' => 0, 'msg'=>'Data not deleted');
        }
        
        return Response()->json($response);  
    }
}
