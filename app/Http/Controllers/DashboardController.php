<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MachineStop;

class DashboardController extends Controller
{
    public function show($id)
    {

        $hour_end = "(CASE WHEN hour_end is null THEN CURRENT_TIMESTAMP     
                          ELSE hour_end 
                    END)";

        $detail_stop  = MachineStop::select('problem', 
                                        'updated_at AS updated',
                                        DB::raw('(CASE WHEN hour_end is null THEN true ELSE false END) AS stoped'),
                                        DB::raw('IFNULL(name_employee, name_position) as responsible'),
                                        DB::raw('DATE_FORMAT(hour_start, "%H:%i") AS hour_start'),
                                        DB::raw('(CASE WHEN hour_end is NULL THEN "" ELSE DATE_FORMAT(hour_end, "%H:%i") END) AS hour_end'),
                                        DB::raw('
                                                (CASE WHEN FLOOR(TIMESTAMPDIFF(MINUTE, hour_start, '.$hour_end.')/60) < 10 
                                                    THEN CONCAT("0", FLOOR(TIMESTAMPDIFF(MINUTE, hour_start, '.$hour_end.')/60))
                                                        WHEN FLOOR(TIMESTAMPDIFF(MINUTE, hour_start, '.$hour_end.')/60) < 1 
                                                    THEN "00"
                                                    ELSE FLOOR(TIMESTAMPDIFF(MINUTE, hour_start, '.$hour_end.')/60)  END) AS hours,
                                                (CASE WHEN MOD(TIMESTAMPDIFF(MINUTE, hour_start, '.$hour_end.'),60) < 10 
                                                    THEN CONCAT("0", MOD(TIMESTAMPDIFF(MINUTE, hour_start, ".$hour_end."),60) ) 
                                                        WHEN MOD(TIMESTAMPDIFF(MINUTE, hour_start, '.$hour_end.'),60) < 1 
                                                    THEN "00" 
                                                    ELSE MOD(TIMESTAMPDIFF(MINUTE, hour_start, '.$hour_end.'),60) 
                                                END) AS minutes
                                            ')
                                    )
                                    ->join('machine', 'machine.id_machine', '=', 'machine_stop.id_machine')
                                    ->leftjoin('employee', 'employee.id_employee', '=', 'machine_stop.id_employee')
                                    ->leftjoin('position', 'position.id_position', '=', 'machine_stop.id_position')
                                    ->orderBy('updated_at', 'DESC')
                                    ->where('machine.id_machine', $id)
                                    ->where('created_at', '>=',  date(dateActual()))
                                    ->get();

        return $detail_stop;
    }

    //obtiene cantiad de maquinas que no se han corregido
    public function getMachineNotRepaired()
    {
        $result = DB::table('machine_stop')
            ->whereNull('hour_end')
            ->where('created_at', '>=', date(dateActual()))
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
            ->where('created_at', '>=', date(dateActual()))
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
                ->where('created_at', '>=', date(dateActual()))
                ->get();

        return $result;

    }

    public function getTotalHourStoped()
    {
        $hour_end = "(CASE WHEN hour_end is null THEN CURRENT_TIMESTAMP     
                          ELSE hour_end 
                    END)";

        $query = "SELECT count(*) as total_stoped,
            machine.id_machine, 
            name_step AS name,  
            hour_end, 
            problem,
            sum(CASE WHEN hour_end is NULL
                THEN 1
             ELSE 0
            END) AS stoped,
                (CASE WHEN FLOOR(sum(TIMESTAMPDIFF(MINUTE, hour_start, ".$hour_end."))/60) < 10 
                    THEN CONCAT('0', FLOOR(sum(TIMESTAMPDIFF(MINUTE, hour_start, ".$hour_end."))/60))
                        WHEN FLOOR(sum(TIMESTAMPDIFF(MINUTE, hour_start, ".$hour_end."))/60) < 1 
                    THEN '00'
                    ELSE FLOOR(sum(TIMESTAMPDIFF(MINUTE, hour_start, ".$hour_end."))/60)  END) AS hours,
                (CASE WHEN MOD(sum(TIMESTAMPDIFF(MINUTE, hour_start, ".$hour_end.")),60) < 10 
                    THEN CONCAT('0', MOD(sum(TIMESTAMPDIFF(MINUTE, hour_start, ".$hour_end.")),60) ) 
                        WHEN MOD(sum(TIMESTAMPDIFF(MINUTE, hour_start, ".$hour_end.")),60) < 1 
                    THEN '00' 
                    ELSE MOD(sum(TIMESTAMPDIFF(MINUTE, hour_start, ".$hour_end.")),60) 
                END) AS minutes
            FROM machine_stop JOIN machine on machine_stop.id_machine = machine.id_machine 
            WHERE created_at >= DATE_FORMAT('".dateActual()."', '%y-%m-%d') GROUP BY id_machine";

        $result = DB::select($query);

        return $result;
    }
}
