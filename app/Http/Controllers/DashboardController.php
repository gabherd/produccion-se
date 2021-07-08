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
    public function getMachineNotRepaired()
    {
        $result = DB::table('machine_stop')
            ->where('hour_end', '=', '00:00')
            ->where('created_at', '>=', dateActual())
            ->count();
            
        return $result;
    }

    //cantidad de paros por maquina
    public function getQtyStopedByMachine()
    {
        $result = DB::table('machine_stop')
            ->select(DB::raw('machine_stop.id_machine, machine.name_step AS name, COUNT(machine.id_machine) as total'))
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

    public function getTotalHourStoped()
    {
        $query = "SELECT count(*) as total_stoped, machine.id_machine, name_step AS name, (CASE WHEN FLOOR(sum(TIMESTAMPDIFF(MINUTE, hour_start, hour_end))/60) < 10 THEN '00' END) as hours, (CASE WHEN MOD(sum(TIMESTAMPDIFF(MINUTE, hour_start, hour_end)),60) < 10 THEN CONCAT('0', MOD(sum(TIMESTAMPDIFF(MINUTE, hour_start, hour_end)),60) ) WHEN MOD(sum(TIMESTAMPDIFF(MINUTE, hour_start, hour_end)),60) < 1 THEN '00' ELSE MOD(sum(TIMESTAMPDIFF(MINUTE, hour_start, hour_end)),60) END) as minutes FROM machine_stop JOIN machine on machine_stop.id_machine = machine.id_machine WHERE created_at >= '".dateActual()."' GROUP BY id_machine";

        $result = DB::select($query);

        return $result;
    }
}
