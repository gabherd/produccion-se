<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--jquery-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
        <!--BOOTSTRAP-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <!--FontAwesome-->
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <!--timepicker-->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <!--DataTables-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
        <!--Ratatable responsive-->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
        <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
      
        <!--css personal-->
        <link rel="stylesheet" href="css/home.css">
        <title>Produccion SH</title>
    </head>
    <body>
        <nav class="navbar navbar-light">
            <span class="navbar-brand mb-0 h1">Produccion SH</span>
            <div class="user-data">
                <div class="user-name">Usuario</div>
                <div class="user-image">
                    <img src="img/owl.svg" class="user-image">
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="add-stop shadow" data-toggle="modal" data-target="#exampleModal">
                <div class="icon-action">
                    <i class="fas fa-plus"></i>
                </div>
                Agregar paro de maquina
            </div>
            <div class="space"></div>
            <div class="view-stop shadow" data-toggle="modal" data-target="#modal-view">
                <div class="icon-action">
                    <i class="fas fa-eye"></i>
                </div>
                Ver paros de maquina
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar paro de maquina</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Maquina</label>
                                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Problema</label>
                                <textarea name="" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hora</label>
                                <div class="content-time">
                                    <input id="time-start" class="form-control"/>
                                    <input id="time-end" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Responsable</label>
                                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text text-muted">Nombre de empleado</small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-save">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ver paros de maquina</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body" style="position: relative; width: 100%">
                           <table id="tbl-stop" class="table table-bordered display responsive nowrap" cellspacing="0" width="100%">
                               <thead class="thead-light">
                                   <tr>
                                       <th>Maquina</th>
                                       <th>Problema</th>
                                       <th>Hora Incio</th>
                                       <th>Hora Fin</th>
                                       <th>Responsable</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <tr>
                                       <td>CA-4006</td>
                                       <td>Contacto marcado</td>
                                       <td>12:00 pm</td>
                                       <td>1:00 pm</td>
                                       <td>03171182</td>
                                   </tr>
                                   <tr>
                                       <td>CA-0589</td>
                                       <td>Baja resistencia</td>
                                       <td>1:00 pm</td>
                                       <td>3:00 pm</td>
                                       <td>03171182</td>
                                   </tr>
                               </tbody>
                           </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-close" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-save">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $('#time-start').timepicker({
                uiLibrary: 'bootstrap4'
            });
            $('#time-end').timepicker({
                uiLibrary: 'bootstrap4'
            });

            $(document).ready(function(){
                var table = $('#tbl-stop').DataTable({
                    responsive: true,
                    autoWidth: true
                }); //dataTable
   
            });

        </script>
    </body>
</html>