@extends('public/layout')

@section('resources')
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/drilldown.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
@endsection()

@section('content')
	<div class="first-charts">
		<div class="content-machine-employee">
			<div class="box-content box-machine">
				<div class="line-box-vertical"></div>
				<div class="body-box">
					<div class="info-box">
						<div class="title-box" id="machineNotRepaired">...</div>
						<div class="subTitle-box">
							<div>Maquinas</div>
							<div>detenidas</div>
						</div>
					</div>
					<div class="image-box">
						<i class="fas fa-pause-circle image-pause"></i>
					</div>
				</div>
			</div>

			<div class="box-content box-employee">
				<div class="line-box-vertical"></div>
				<div class="body-box">
					<div class="info-box">
						<div class="title-box">{{ getQtyEmployees() }}</div>
						<div class="subTitle-box">
							<div>Empleados</div>
							<div>registrados</div>
						</div>
					</div>
					<div class="image-box">
						<i class="fas fa-users image-users"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="box-content box-setup">
			<div  id="piechart" style="width: 100%; height: 200px;"></div>
		</div>

		<div class="box-content box-total-stoped" >
			<div id="myChart" style="width: 100%; height: 200px;"></div>
		</div>
	</div>
	<br>
	<div class="box-content box-total-hours">
		<div id="hour-stop" style="height: 400px; width: 100%; background: #fff;"></div>
	</div>
@endsection()

@section('scripts')
	<script src="js/public.js"></script>
	<script src="js/dashboard.js"></script>
@endsection()