@extends('public/layout')

@section('resources')
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/drilldown.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>

	 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	 <link rel="stylesheet" type="text/css" href="css/dashboard.css">
@endsection()

@section('content')
	<div style="display: flex; justify-content: space-between;">
		<div class="content-machine-employee">
			<div class="box-content box-machine">
				<div class="line-box-vertical"></div>
				<div class="body-box">
					<div class="info-box">
						<div class="title-box">5</div>
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
						<div class="title-box">31</div>
						<div class="subTitle-box">Empleados</div>
					</div>
					<div class="image-box">
						<i class="fas fa-users image-users"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="box-content box-setup">
			<div  id="piechart" style="width: 300px; height: 200px;"></div>
		</div>

		<div class="box-content" >
			<canvas id="myChart" width="500" height="200"></canvas>
		</div>
	</div>
	<br>
	<div class="box-content">
		<div id="hour-stop" style="height: 400px; width: 100%; background: #fff;"></div>
	</div>
@endsection()

@section('scripts')
	<script src="js/public.js"></script>
	<script src="js/dashboard.js"></script>
@endsection()