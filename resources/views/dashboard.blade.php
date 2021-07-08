@extends('public/layout')

@section('title') Dashboard @endsection()

@section('resources')
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
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
	<br>
	<div class="box-content box-summary">
		<div class="title-content-summary">Resumen de paros</div>
		<div class="summary-stop">
			<!--div class="card-stops shadow">
				<div class="header-card-stop">Bimetal yoke</div>
				<div class="body-card-stop">
					<div class="description-stop">
						<div><strong>Maquina: </strong> <span>CA-4006</span></div>
						<div><strong>Proceso: </strong> <span>Bimetal yoke</span></div>
						<div><strong>Cantidad de paros: </strong> <span>4</span></div>
						<div class="hour-lost"><strong>Horas perdidas: </strong> <span>01:20</span></div>
					</div>
					<div class="image-stop">
						<img src="img/materials/bt.jpg" alt="">
					</div>
				</div>
				<div class="footer-card-stop">
					<div class="btn btn-detail-stop">Detalles <i class="fas fa-plus"></i> </div>
				</div>
			</div-->
		</div>
	</div>
@endsection()

@section('scripts')
	<script src="js/dashboard.js"></script>
@endsection()