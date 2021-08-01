@extends('public/layout')

@section('title') Dashboard @endsection()

@section('resources')
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   	<!--DataTables-->
   	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
   	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
   	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
   	<!--Ratatable responsive-->
   	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
   	<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
	<!--charts-->
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
		<table id="tbl-summary-stop" class="table table-bordered display responsive nowrap" cellspacing="0" width="100%">
			<thead  class="thead-light">
				<tr>
					<th>Maquina</th>
					<th>Proceso</th>
					<th>Cantidad de paros</th>
					<th>Tiempo detenido</th>
					<th>Detalles</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>


@endsection()

@section('modals')
    <!-- Modal detail-->
       <div class="modal fade" id="modal-detail-stop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg modal-dialog-centered">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Ver paros de maquina</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                           </button>
                   </div>
                   <div class="modal-body" style="position: relative;">
                   	<div class="main-detail-stop">
                   		<div class="box-description-stop">
	                   		<div class="row-detail-stop">
	                   			<div class="box-detail-stop">
	                   				<div class="title-detail-stop">Maquina</div>
	                   				<div class="description-detail-stop">CA-1353</div>
	                   			</div>
	                   			<div class="box-description">
	                   				<div class="title-detail-stop">Proceso</div>
	                   				<div class="description-detail-stop">Bimetal Yoke</div>
	                   			</div>
	                   			<div class="box-detail-stop">
	                   				<div class="title-detail-stop">Cantiad de paros</div>
	                   				<div class="description-detail-stop">1</div>
	                   			</div>
	                   			<div class="box-description">
	                   				<div class="title-detail-stop">Tiempo detenido</div>
	                   				<div class="description-detail-stop">01:00</div>
	                   			</div>
	                   		</div>
	                   		<div class="row-detail-stop-current">
	                   			<div class="box-detail-stop">
	                   				<div class="title-detail-stop">Estado</div>
	                   				<div class="description-detail-stop">Detenido</div>
	                   			</div>
	                   			<div class="box-description">
	                   				<div class="title-detail-stop">Problema</div>
	                   				<div class="description-detail-stop">Punto c alto</div>
	                   			</div>
	                   		</div>
                   		</div>
                   	</div>
                          <table id="tbl-detail-stop" class="table table-bordered display responsive nowrap" cellspacing="0" width="100%">
                              <thead class="thead-light">
                                  <tr>
                                       <th>Problema</th>
                                       <th>Hora Incio</th>
                                       <th>Hora Fin</th>
                                       <th>Tiempo</th>
                                       <th>Responsable</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-close" data-dismiss="modal">Aceptar</button>
                   </div>
               </div>
           </div>
       </div>

@endsection()


@section('scripts')
	<script src="js/dashboard.js"></script>
@endsection()