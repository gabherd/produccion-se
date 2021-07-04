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

    //obtiene cantiad de maquinas que no se han corregido
    public function getQtyMachineStoped()
    {
        $result = DB::table('machine_stop')
            ->where('hour_end', '=', '00:00')
            ->count();
            
        return $result;
    }

    //cantidad de paros por maquina
    public function getQtyStopedByMachine()
    {
        $result = DB::table('machine_stop')
            ->select(DB::raw('COUNT(machine.id_machine) as total,  machine_stop.id_machine'))
            ->join('machine', 'machine.id_machine', '=', 'machine_stop.id_machine')
            ->groupBy('machine_stop.id_machine')
            ->where('created_at', '>=', dateActual())
            ->get();
            
        return $result;
    }

    //obtiene cuantas cuantes el setup corrigio una maquina
    public function getNameResponsable(){
        $result = DB::table('machine_stop')
                ->select(DB::raw('IFNULL(employee.name_employee, position.name_position) as name_responsable, IFNULL(machine_stop.id_employee, machine_stop.id_position) as id_responsable, COUNT(*) as total'))
                ->leftjoin('employee', 'machine_stop.id_employee', '=', 'employee.id_employee')
                ->leftjoin('position', 'machine_stop.id_position', '=', 'position.id_position')
                ->groupBy('id_responsable')
                ->where('created_at', '>=', dateActual())
                ->get();

        return $result;

    }

    public function getHourStoped()
    {
        
    }


}
