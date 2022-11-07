@extends('layouts.refriPeruLayout')

@section('content')
   <div class="content" id="incidencia-body">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Adminox</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                        <h4 class="page-title lineatitle"><i class="fe-file-text"></i> GESTIÓN DE INCIDENTES</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <button type="button" id="btn-agregar" class="btn btn-primario"><i class="fas fa-plus"></i> Agregar</button>   
                    </div>    
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive titleform">
                        <h4 class="header-title headertitle"><i class="far fa-caret-square-down vermas" option="0"></i> Filtros</h4>
                    </div>    
                </div>    
            </div>

            <div class="container cntfiltro">
            <div class="row" style="padding-bottom:15px;">
                <div class="col-md-3">
                    <h5 class="headerh">N° Incidente</h5>
                    <input type="text" class="form-control bordecaja" name="text-code" id="text-code" placeholder="N° Incidente" maxlength="15" onKeyPress="return soloNumeros(event)"  />
                </div>
                <div class="col-md-5">
                    <h5 class="headerh">Responsable</h5>
                    <select class="form-control" id="responsable" name="responsable">
                        <option value="0">Todos</option>
                        @foreach($respons as $rpble)
                        <option value="{{ $rpble->cod_trabajador }}">{{ $rpble->dsc_nombres.','.$rpble->dsc_apellido_paterno.' '.$rpble->dsc_apellido_materno }}</option>
                        @endforeach        
                    </select>
                </div>    
            </div>

            <div class="row fondoheader">
                <!--<div class="cntbotonessearch">-->
                    <div class="col-md-3">
                        <h5 class="headerh">Cliente</h5>
                        <input type="text" class="form-control bordecaja" name="text-filter" id="text-filter" placeholder="Razon social"  />
                    </div>
                    <div class="col-md-3">
                        <h5 class="headerh">Estado</h5>
                        <select class="form-control" id="estado" name="estado">
                            <option value="0">Todos</option>
                            @foreach($estados as $state)
                            <option value="{{ $state->cod_estadoincidente }}">{{ $state->dsc_estadoincidente }}</option>
                            @endforeach        
                        </select>
                    </div>
                    <div class="col-md-2">
                        <h5 class="headerh">F. Desde</h5>
                        <input type="date" class="form-control bordecaja" id="fecha_ini"  />
                    </div>
                    <div class="col-md-2">
                        <h5 class="headerh">F. Hasta</h5>
                        <input type="date" class="form-control bordecaja" id="fecha_hasta"  />
                    </div>
                    <div class="col-md-1">
                        <h5 class="headerh">&nbsp;</h5>
                        <button class="btnbuscar btn-search">
                            <i class="fe-search"></i>
                        </button>
                    </div>
                    <div class="col-md-1">
                        <h5 class="headerh">&nbsp;</h5>
                        <button class="btnlimpiar btn-clear">
                            <i class="fe-rotate-cw"></i>
                        </button>
                    </div>
                <!--</div>-->    
            </div>

            </div>

            <div class="row fondocabecera">
                <div class="col-12">
                    <div class="table-responsive titleform">
                        <h4 class="header-title headertitle"><i class="fe-copy"></i> Listado de incidentes</h4>
                    </div>    
                </div>
                <div class="col-12">
                    <div id="incidente-content"></div>
                </div>
            </div> <!-- end row -->

        </div> <!-- end container-fluid -->

    </div> <!-- end content -->
@endsection

@push('scripts')
<script type="text/javascript">
    //solo numeros
    function soloNumeros(e){
        var key = window.Event ? e.which : e.keyCode
        return ((key >= 48 && key <= 57) || (key==8) || (key==45) )
    }

    //Definimos la fechas para la busqueda:
    var dia   = "01";
    var date  = new Date();         //Se define la fecha actual
    var day   = date.getDate();
    var month = date.getMonth() + 1;
    var year  = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var fini = year + "-" + month + "-" + dia; 
    var fhoy = year + "-" + month + "-" + day;    //Fecha de hoy

    document.getElementById('fecha_ini').value   = fini;
    document.getElementById('fecha_hasta').value = fhoy;

    $(document).ready(function(){

        //Se hace el slider.
        $('.vermas').on('click',function(){
            var opt = $(this).attr('option');
            //
            if(opt=='0'){
                $(this).removeClass("fa-caret-square-down");
                $(this).addClass("fa-caret-square-up");
                //
                $('.cntfiltro').fadeIn("slow");
                $('.cntfiltro').css('display','inline-block');

                $(this).attr('option','1');   
            }else{
                $(this).removeClass("fa-caret-square-up");
                $(this).addClass("fa-caret-square-down");
                //
                $('.cntfiltro').fadeOut("slow");
                $('.cntfiltro').css('display','none');
                $(this).attr('option','0');
            }
            
        });

        $('#estado').select2();

        $('#responsable').select2();

        $("#estado").change(function (){
            $("#incidente-content").html("");
            $("#incidente-sort").show();
            loadPageData();
        });

        $("#responsable").change(function(){
            $("#incidente-content").html("");
            $("#incidente-sort").show();
            loadPageData();    
        });

        $("#text-filter").keypress(function (e){
            var key    = e.which;
            var filtro = $(this).val();
            var len    = filtro.length;
            if(key === 13){
              if(len>3){
                  $("#incidente-content").html("");
                  $("#incidente-sort").show();
                  loadPageData();  
              }else{
                  Swal.fire(
                    'Aviso',
                    'Debe ingresar mínimo 4 caracteres',
                    'warning'
                    );
                    return false; 
              }  
              
            }
            return true;
        });

        $("#text-code").keypress(function(e){
            var tecla = e.which;
            var code  = $(this).val();
            var long  = code.length;
            if(tecla === 13){
                if(long>2){
                    $("#incidente-content").html("");
                    $("#incidente-sort").show();
                    loadPageData();
                }else{
                    Swal.fire(
                    'Aviso',
                    'Debe ingresar mínimo 3 caracteres',
                    'warning'
                    );
                    return false; 
                }
            }
            return true;
        });

        $(".btn-search").click(function(){
            var date1,date2,fechaInicio,fechaFin;

            date1 = $('#fecha_ini').val();
            date2 = $('#fecha_hasta').val();
            //
            fechaInicio = new Date(date1).getTime();
            fechaFin    = new Date(date2).getTime();

            var diff    = fechaFin - fechaInicio;

            if(date1!='' && date2!=''){
                if(diff>=0){
                    $("#incidente-content").html("");
                    $("#incidente-sort").show();
                    loadPageData();
                }else{
                    Swal.fire(
                    'Aviso',
                    'La fecha final debe ser mayor a la fecha inicial',
                    'warning'
                    );
                    return false;   
                }
            }else{
                Swal.fire(
                    'Aviso',
                    'Debe ingresar un rango de fechas',
                    'warning'
                );
                return false; 
            }

            
        });

        $(".btn-clear").click(function(){
            window.location = "{{ url('incidencia') }}";
        });

        loadPageData();

    });

    //Se inicia con la funcion onload
    function loadPageData(){
        $.ajax({
            type: 'GET',
            url: "{{url('incidencia/listar')}}",
            data: {
                'idstate': $("#estado").val(),
                'search' : $("#text-filter").val(),
                'fdesde' : $("#fecha_ini").val(),
                'fhasta' : $("#fecha_hasta").val(),
                'codresp': $("#responsable").val(),
                'codincd': $("#text-code").val(),
            },
            beforeSend: function () {
                $("#incidencia-body").LoadingOverlay("show");
            },
            complete: function () {
                $("#incidencia-body").LoadingOverlay("hide");
            },
            success:function(result){
                var data = result;
                //console.log(data.items.length);
                if(data.items.length > 0){
                    $("#incidente-content").html(getIncidenciaTable(data.items));

                    $("#tbl-incidente").DataTable({
                        responsive: true,
                        filter: false,
                        lengthChange: true,
                        ordering: false,
                        orderMulti: false,
                        paging : true,
                        info: true,
                        language:{
                          "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                        }
                        /*dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excel',
                                title: 'Reporte de incidencias'
                            }
                        ]*/
                    });
                }else{
                    $("#incidente-content").html(getEmptyContent());
                }
            }
        });    
    }

    function getIncidenciaTable(items){

        var j=1;
        var fondo,ruta;
        var body  = '<div class="card-box table-responsive">';

        body += '<div class="row">' +
                '<div class="col-md-2" style="margin-bottom:0.5em;">Exportar: <img src="{{ asset("assets/images/icons/icon_excel.png") }}" title="Click para exportar" onclick="exportar()" style="height:30px;cursor:pointer;"></div>' +
                '</div>';
            
        body += '<table id="tbl-incidente" class="table table-bordered  dt-responsive nowrap" style="border-collapse:collapse; border-spacing: 0; width: 100%;">' +
                    '<thead>' +
                    '<tr class="headtable">' +
                    '<th>N°</th>' + 
                    '<th>Codigo</th>' + 
                    '<th>Tipo</th>' +
                    '<th>Titulo</th>' +
                    '<th>Fch. Reporte</th>' +
                    '<th>Cliente</th>' +
                    '<th>Prioridad</th>' +
                    '<th>Estado</th>' +
                    '<th>Opciones</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';

        $.each(items, function (index, value){

        if(value.codestado=='001'){
            fondo = '#f96a74';
            ruta  = '{{ asset("assets/images/icons/sema-rojo.png") }}';
        }else if(value.codestado=='002'){
            fondo = '#ffa91c';
            ruta  = '{{ asset("assets/images/icons/sema-amarillo.png") }}';
        }else if(value.codestado=='003'){
            fondo = '#32c861';
            ruta  = '{{ asset("assets/images/icons/sema-verde.png") }}';
        }else if(value.codestado=='004'){
            fondo = '#8c9396';
            ruta  = '{{ asset("assets/images/icons/sema-plomo.png") }}';
        }else{
            fondo = '#000000';
            ruta  = '{{ asset("assets/images/icons/sema-otro.png") }}';  
        }

        body += '<tr>' + 
                    '<td>' + j + '</td>' +
                    '<td>' + value.code + '</td>' +
                    '<td>' + value.tipo_incidente + '</td>' +
                    '<td>' + value.tit_incidente + '</td>' +
                    '<td>' + value.fech_reporte + '</td>' +
                    '<td>' + value.nomcliente + '</td>' +
                    '<td>' + value.prioridad + '</td>' +
                    '<td><img src="' + ruta + '" alt="lang-image" title="' + value.estado + '" width="40"></td>' +
                    '<td style="text-align:center;">' +
                    '<a class="urlicon" title="Editar" href="javascript::void(0)" onclick="editar(' + "'" + value.code + "'" + ')" >' +
                    '<i class="fas fa-edit"></i>' +
                    '</a>&nbsp;' +
                    '<a href="javascript::void(0)" class="urlicon" title="Eliminar" onclick="eliminar(' + "'" + value.code + "'" + ')" >' +
                    '<i class="fas fa-trash-alt"></i>' +
                    '</a>' +
                    '</td>' +
                    '</tr>';

        j++;

        });

        body += '</tbody>' +
                '</table>' +
                '</div>';        

        return body;

    }

    //No se encontraron registros
    function getEmptyContent(mensaje = "No se encontraron registros"){
    return "<div class=\"row\" style=\"padding-top: 10px;\">" +
           "<div class=\"col-12\">" +
           "<div class=\"alert alert-info text-center\">" + mensaje + "</div>" +
           "</div>" +
           "</div>";
    }

    //Funcion para exportar a Excel
    function exportar(){

        var query = {
            'idstate': $("#estado").val(),
            'search' : $("#text-filter").val(),
            'fdesde' : $("#fecha_ini").val(),
            'fhasta' : $("#fecha_hasta").val(),
            'codresp': $("#responsable").val(),
            'codincd': $("#text-code").val(),
        }

        window.location = "{{ url('incidencia/exportar') }}?" + $.param(query) ;
    }

    //Funcion para editar
    function editar(id){
        window.location = "{{ url('incidencia/editar') }}" + "/" + id;
    }

    //Funcion para eliminar
    function eliminar(id){
            var $code = id;
            console.log($code);
            Swal.fire({
                title: '¿Está seguro de eliminar este incidente?',
                text: 'Una vez eliminado no se podrá recuperar!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si'
                }).then((result) => {
                    if(result.value){
                        $.ajax({
                            url : "{{ url('incidencia/eliminar')}}",
                            type: "get",
                            data: {"code":id},
                            success:function(result){
                                if(result == "ok"){
                                    //console.log('cambiado');
                                    Swal.fire({
                                        title:'Eliminado!',
                                        text: 'El incidencia ha sido eliminado.',
                                        icon:'success'  
                                    }).then((result)=>{
                                        window.location = "{{ url('incidencia') }}";
                                    });

                                }else{
                                    console.log('Error');
                                    Swal.fire(
                                      'Error',
                                      'Ha habido un error interno',
                                      'error'
                                    )
                                }
                            }
                        });
                    }
                })
    }
        
    $("#btn-agregar").on('click',function(){
        window.location = "{{ url('incidencia/crear') }}";
    });

    

</script>
@endpush