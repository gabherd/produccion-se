@extends('public/layout')

@section('title') Paros @endsection()

@section('resources')
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!------------link rel="stylesheet" href="/resources/demos/style.css"-------------->
        <!--timepicker-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <!--Sweetalert-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.6/sweetalert2.min.css"/>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
        <!--DataTables-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
        <!--Ratatable responsive-->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
        <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
        <!--Moment-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!--lodash-->
        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.20/lodash.min.js"></script>
        <!--css personal-->
        <link rel="stylesheet" href="css/machine-stop.css">
        <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}"> 
@endsection()

@section('content')
@section('title-section') Paros de M??quina @endsection()
    @if(dateActual() == date('Y-m-d'))
        <div class="btn-add-stop shadow cursor" onclick='saveStop();' data-toggle="modal" data-target="#mdl-add-stop">
            <div class="icon-action">
                <i class="fas fa-plus"></i>
            </div>Agregar <span class="txt-description">&nbsp; paro de m??quina <span>
        </div>
    @endif


    <div class="space"></div>
    <div class="view-stop shadow" data-toggle="modal" data-target="#modal-view">
        <div class="icon-action">
            <i class="fas fa-eye"></i>
        </div>
        Ver paros de m??quina
    </div>
    <div class="container-tbl-stop shadow">
        <table id="tbl-stop" class="tbl-stop table table-bordered display responsive nowrap" cellspacing="0" width="100%">
            <thead class="thead-light">
                <tr>
                    <th>M??quina</th>
                    <th>Descripci??n</th>
                    <th>Problema</th>
                    <th>Hora Incio</th>
                    <th>Hora Fin</th>
                    <th>Tiempo</th>
                    <th>Responsable</th>
                    <th>Acciones</th>
                    <th></th>
                </tr>
            </thead>
             <tbody>
             </tbody>
        </table>
    </div>
@endsection()

@section('modals')
    <!-- Modal show table-->
            <div class="modal fade" id="modal-view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ver paros de m??quina</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body" style="position: relative;">
                               <table id="tbl-stop-mobile" class="tbl-stop table table-bordered display responsive nowrap" cellspacing="0" width="100%">
                                   <thead class="thead-light">
                                       <tr>
                                            <th>M??quina</th>
                                            <th>Descripci??n</th>
                                            <th>Problema</th>
                                            <th>Hora Incio</th>
                                            <th>Hora Fin</th>
                                            <th>Tiempo</th>
                                            <th>Responsable</th>
                                            <th>Acciones</th>
                                            <th></th>
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

    <!-- Modal add stop-->
            <div class="modal fade" id="mdl-add-stop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title-modal-add-stop">Agregar paro de m??quina</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <form id="create-stop">
                                @csrf
                                <div class="form-group">
                                    <label for="id_machine">M??quina</label>
                                    <div class="form-group-icon">
                                        <i class="fas fa-search"></i>
                                        <input id="id_machine" name="machine" type="number" class="form-control" placeholder="Buscar">
                                        <div class="msg-error-machine alert alert-danger">
                                            M??quina no encontrada, selecciona una de la lista
                                        </div>
                                    </div>
                                    <small id="description_machine" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label for="problem">Problema</label>
                                    <input id="problem" name="problem" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Hora</label>
                                    <div class="content-time">
                                        <div class="group-time">
                                            <div class="description-hour">Hora de inicio</div>
                                            <input id="hour_start"  data-hour_start="" name="hour_start" class="form-control"/>
                                            <div class="msg-error-repeated alert alert-danger">
                                                Ya tienes un registro con la misma hora de inicio
                                            </div>
                                        </div>
                                        <div class="group-time">
                                            <div class="description-hour">Hora de correcci??n</div>
                                            <input id="hour_end" name="hour_end" class="form-control"/>
                                            <div class="msg-error-hour alert alert-danger">
                                                La hora de correcci??n est?? terminando antes de la hora de inicio
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee">Responsable</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="swt-employee" class="custom-control-input" id="swt-id_employee" checked>
                                        <label class="custom-control-label" for="swt-id_employee">N??mero de empleado</label>
                                    </div>
                                    <div id="name_employee">
                                        <div class="form-group-icon">
                                            <i class="fas fa-search"></i>
                                            <input id="id_employee" type="number" name="employee" class="form-control" placeholder="Buscar">
                                        </div> 
                                        <small id="name-employee" class="form-text text-muted"></small>
                                    </div>
                                    <div id="position_employee">
                                        <select name="position" id="slt-position" class="form-control">
                                            <option value="0">Selecciona un puesto</option>
                                            <option value="1">Calidad</option>
                                            <option value="2">Operador</option>
                                            <option value="3">Setup</option>
                                            <option value="4">T??cnico</option>
                                        </select>
                                    </div>  

                                </div>
                                <button id="submit-stop" class="d-none"></button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancelar</button>
                            <button id="btn-save-stop" data-id='' data-submit="create" type="button" class="btn btn-save">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Modal add employee-->
            <div class="modal fade" id="mdl-add-employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar Empleado</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <form id="create-employee">
                                @csrf
                                <div class="form-group">
                                    <label for="number-employee">N??mero de empleado</label>
                                    <input id="number-employee" name="number-employee" type="number" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="position">Puesto</label>
                                    <select name="position" class="form-control">
                                        <option value="Calidad">Calidad</option>
                                        <option value="Operador">Operador</option>
                                        <option value="Setup">Setup</option>
                                        <option value="Tecnico">T??cnico</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="employee">Nombre</label>
                                    <input id="name-empl" type="text" name="name" class="form-control" id="employee">
                                </div>
                                <button id="submit-employee" class="d-none"></button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancelar</button>
                            <button id="btn-save-employee" type="button" class="btn btn-save">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
@endsection()

@section('scripts')
    <script src="js/machine-stop.js"></script>
@endsection()
