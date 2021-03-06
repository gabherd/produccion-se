<?php
use Illuminate\Support\Facades\DB;

	function getQtyEmployees(){
		$qtyEmployee = DB::table('employee')
			->where('position', '=', 'Operador')
			->where('isActive', '=', '1')
			->count();

        return $qtyEmployee;
	}

	function dateActual(){
		if (Session::has('customDate')) {
			return Session::get('customDate');
		}else{
			return date('Y-m-d');
		}
	}
?>