@extends('layouts.refriPeruLayout')

@section('content')
   <div class="content" id="equipo-body">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        {{-- <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Adminox</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div> --}}
                        <h4 class="page-title lineatitle"><i class="fe-file-text"></i> GESTIÓN DE EQUIPOS</h4>
                        <div class="col-md-2">
                            <h5 class="headerh">&nbsp;</h5>
                            <button class="btnlimpiar btn-clear">
                                <i class="fe-rotate-cw"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-12">
                    <div class="table-responsive titleform">
                        <h4 class="header-title headertitle"><i class="far fa-caret-square-down vermas" option="0"></i> Filtros</h4>
                    </div>    
                </div>    
            </div> --}}

            <div class="row" style="padding-bottom:15px;">
                <div class="col-md-3">
                    <h5 class="headerh">Sede</h5>
                    <select class="form-control" id="sede" name="sede">
                        <option value="0">Todos</option>
                        @foreach($listaSede as $list)
                            <option value="{{ $list->num_linea }}">{{ $list->dsc_nombre_direccion }}</option>
                        @endforeach  
                    </select>
                </div>
                <div class="col-md-3">
                    <h5 class="headerh">Nivel 1</h5>
                    <select class="form-control" id="ubicacion" name="ubicacion">
                        <option value="0">Todos</option>
                    </select>
                </div>
                <div class="col-md-3" id="divUbicacion2" style="display: none">
                    <h5 class="headerh">Nivel 2</h5>
                    <select class="form-control" id="ubicacion2" name="ubicacion2">
                        <option value="0">Todos</option>
                    </select>
                </div>
                <div class="col-md-3" id="divUbicacion3" style="display: none">
                    <h5 class="headerh">Nivel 3</h5>
                    <select class="form-control" id="ubicacion3" name="ubicacion3">
                        <option value="0">Todos</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3" id="divUbicacion4" style="display: none">
                    <h5 class="headerh">Nivel 4</h5>
                    <select class="form-control" id="ubicacion4" name="ubicacion4">
                        <option value="0">Todos</option>
                    </select>
                </div>    
            </div>

            <div class="row fondocabecera">
                <div class="col-12">
                    <div class="table-responsive titleform">
                        <h4 class="header-title headertitle"><i class="fe-copy"></i> Listado de ubicaciones</h4>
                    </div>    
                </div>
                <div class="col-12">
                    <div id="equipo-content"></div>
                </div>
            </div> <!-- end row -->

        </div> <!-- end container-fluid -->

    </div> <!-- end content -->

        {{-- ---------------------Modal detalle equipo------------------------------- --}}
        <div class="modal fade" id="modalDetalleEquipo" tabindex="-1" role="dialog" aria-labelledby="modalDetalleEquipoLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="max-width:80% !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDetalleEquipoLabel"></h5><h5 class="modal-title" id="EstadoDetalleEquipo"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#detalleEquipo" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                    <span class="d-none d-sm-block">Detalle</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#intervencion" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Intervencion</span>
                                </a>
                            </li>
                                        
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="detalleEquipo">
                                <div id="detalleEquipo-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="mb-1 mt-3 text-muted">Tipo</label>
                                            <input type="text" name="tipoEquipo" id="tipoEquipo" class="form-control" value="" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="mb-1 mt-3 text-muted">Subtipo</label>
                                            <input type="text" name="subtipoEquipo" id="subtipoEquipo" class="form-control" value="" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="mb-1 mt-3 text-muted">Marca</label>
                                            <input type="text" name="marcaEquipo" id="marcaEquipo" class="form-control" value="" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="mb-1 mt-3 text-muted">Modelo</label>
                                            <input type="text" name="modeloEquipo" id="modeloEquipo" class="form-control" value="" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="mb-1 mt-3 text-muted">Act. Fijo</label>
                                            <input type="text" name="actFijoEquipo" id="actFijoEquipo" class="form-control" value="" disabled>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="mb-1 mt-3 text-muted">Inventario</label>
                                            <input type="text" name="inventarioEquipo" id="inventarioEquipo" class="form-control" value="" disabled>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="mb-1 mt-3 text-muted">N° de Serie</label>
                                            <input type="text" name="numSerieEquipo" id="numSerieEquipo" class="form-control" value="" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="mb-1 mt-3 text-muted">Sede</label>
                                            <input type="text" name="sedeEquipo" id="sedeEquipo" class="form-control" value="" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="mb-1 mt-3 text-muted">Ubicación</label>
                                            <input type="text" name="ubicacionEquipo" id="ubicacionEquipo" class="form-control" value="" disabled>
                                        </div>
                                    </div>
                                </div>                    
                            </div>
                            <div class="tab-pane" id="intervencion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="intervencion-content"></div> 
                                    </div>
                                </div>               
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
<script type="text/javascript">
    //solo numeros
    // function soloNumeros(e){
    //     var key = window.Event ? e.which : e.keyCode
    //     return ((key >= 48 && key <= 57) || (key==8) || (key==45) )
    // }

    $(document).ready(function(){
        //Combitos
        $('#sede').select2();
        $('#ubicacion').select2(); 
        $('#ubicacion2').select2();
        $('#ubicacion3').select2();
        //Se hace el slider filter.
        // $('.vermas').on('click',function(){
        //     var opt = $(this).attr('option');
        //     //
        //     if(opt=='0'){
        //         $(this).removeClass("fa-caret-square-down");
        //         $(this).addClass("fa-caret-square-up");
        //         //
        //         $('.cntfiltro').fadeIn("slow");
        //         $('.cntfiltro').css('display','inline-block');

        //         $(this).attr('option','1');   
        //     }else{
        //         $(this).removeClass("fa-caret-square-up");
        //         $(this).addClass("fa-caret-square-down");
        //         //
        //         $('.cntfiltro').fadeOut("slow");
        //         $('.cntfiltro').css('display','none');
        //         $(this).attr('option','0');
        //     }
            
        // });

        $("#sede").change(function (){
            //Aqui se llama a la ubicacion
            var linea = $(this).val();
            var codCliente = "{{$codCliente}}";
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : "{{ url('equipo/ubicaciones')}}",
                type: 'GET',
                data: {
                    'codCliente' : codCliente,
                    'numLinea' : linea
                },
                success:function(data){
                    //console.log('aqui', data);
                    $('#ubicacion').html(data);
                    //$('#ubicacion').trigger('change');   
                }
            });
            //Se llama al equipo content
            
            $("#equipo-content").html("");
            loadPageData();
        });

        ///// aqui deberia ser cuando ubicacion cambia
        //$("#ubicacion").change(function (){
            $("#ubicacion").change(function (){
            //Aqui se llama a la ubicacion2
            var linea = $('#sede').val();
            var codCliente = "{{$codCliente}}";
            var lineaSup = $('#ubicacion').val();
            //console.log('lineaEnSelect', lineaSup);
            $.ajax({
                url : "{{ url('equipo/ubicaciones2')}}",
                type: 'GET',
                data: {
                    'codCliente' : codCliente,
                    'numLinea' : linea,
                    'lineaSuperior' : lineaSup
                },
                success:function(data){ 
                    console.log('numLinea',linea, 'lineaSuperior' , lineaSup);   
                    document.getElementById("divUbicacion2").style.display = "block";               
                    $('#ubicacion2').html(data);
                    //$('#ubicacion2').trigger('change'); 
                    
                    //console.log('lineaSuperior', data);  
                }
                
            });
            //Se llama al equipo content
            $("#equipo-content").html("");
            loadPageData();
            });
        //});
        
        /////fin cambio de ubicacion..
        $("#ubicacion2").change(function (){
            //Aqui se llama a la ubicacion2
            var linea = $('#sede').val();
            var codCliente = "{{$codCliente}}";
            var lineaSup = (!$('#ubicacion2').val().split('+')[1])? $('ubicacion2').val() : $('#ubicacion2').val().split('+')[0];
            //console.log('lineaEnSelect', lineaSup);
            $.ajax({
                url : "{{ url('equipo/ubicaciones3')}}",
                type: 'GET',
                data: {
                    'codCliente' : codCliente,
                    'numLinea' : linea,
                    'lineaSuperior' : lineaSup
                },
                success:function(data){ 
                    //console.log('numLinea',linea, 'lineaSuperior' , lineaSup);   
                    document.getElementById("divUbicacion3").style.display = "block";               
                    $('#ubicacion3').html(data);
                    //console.log('lineaSuperior', data);  
                }
                
            });
            //Se llama al equipo content
            $("#equipo-content").html("");
            loadPageData();
            });


        //here start the triggers for the filters..
        // $("#ubicacion").change(function(){
        //     $("#equipo-content").html("");
        //     loadPageData();    
        // });
        $("#ubicacion2").change(function(){
            $("#equipo-content").html("");
            loadPageData();    
        });
     
        $(".btn-clear").click(function(){
            window.location = "{{ url('equipo/detalle') }}";
        });

        loadPageData();

    });

    //Se inicia con la funcion onload
    function loadPageData(){
        var lineaSup = $('#ubicacion').val().split('+')[1];
        var linea = $('#ubicacion').val().split('+')[0];
        $.ajax({
            type: 'GET',
            url: "{{url('equipo/listar2')}}",
            data: {
                'sede'     : $("#sede").val(),
                'ubicacion'  : linea,
                'ubicacion2'  : lineaSup
            },
            beforeSend: function () {
                $("#equipo-body").LoadingOverlay("show");
            },
            complete: function () {
                $("#equipo-body").LoadingOverlay("hide");
            },
            success:function(result){
                var data = result;
                //console.log('catidad de filas',data.items.length, 'codigo de sede', sede.value, 'ubicacion', ubicacion.value, 'ubicacion2', ubicacion2.value);
                if(data.items.length > 0 && sede.value!=0 ){
                    $("#equipo-content").html(getEquipoTable(data.items));

                    $("#tbl-equipo").DataTable({
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
                    });
                }else{
                    $("#equipo-content").html(getEmptyContent());
                }
            }
        });    
    }

    function getEquipoTable(items){

        var j=1;
        var body  = '<div class="card-box table-responsive">';

        body += '<div class="row">' +
                '<div class="col-md-2" style="margin-bottom:0.5em;">Exportar: <img src="{{ asset("assets/images/icons/icon_excel.png") }}" title="Click para exportar" onclick="exportar()" style="height:30px;cursor:pointer;"></div>' +
                '</div>';
            
        body += '<table id="tbl-equipo" class="table table-bordered dt-responsive" style="font-size:16px; border-collapse:collapse; border-spacing:0; width:100%;">' +
                    '<thead>' +
                    '<tr class="headtable">' +
                    '<th>N°</th>' + 
                    '<th>Código</th>' +
                    '<th>Sede</th>' + 
                    '<th>Ubicación</th>' + 
                    '<th>Nombre</th>' + 
                    '<th>Tipo</th>' +
                    '<th>Sub-tipo</th>' +
                    '<th>Marca</th>' +
                    '<th>Modelo</th>' +
                    '<th>Opciones</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';

        $.each(items, function (index, value){

        body += '<tr>' + 
                    '<td>' + j + '</td>' +
                    '<td>' + value.code + '</td>' +
                    '<td>' + value.sede + '</td>' +
                    '<td>' + value.ubicacion + '</td>' +
                    '<td>' + value.nombre + '</td>' +
                    '<td>' + value.nomtipo + '</td>' +
                    '<td>' + value.nomsubtipo + '</td>' +
                    '<td>' + value.marca + '</td>' +
                    '<td>' + value.modelo + '</td>' +
                    '<td style="text-align:center;">' +
                    '<a class="urlicon" title="Ver detalle" href="javascript:void(0)" onclick="verdetalle(' + "'" + value.code + "'" + ')" >' +
                    '<i class="dripicons-preview"></i>' +
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

    function verdetalle(codigo){
        $('#modalDetalleEquipo').modal('show');
        var cod_modelo = '';

        $.ajax({
            type: 'GET',
            url: "{{url('equipo/modalDetalle')}}",
            data: {
                'cod_equipo' : codigo,
            },
            beforeSend: function () {
                $("#equipo-body").LoadingOverlay("show");
            },
            complete: function () {
                $("#equipo-body").LoadingOverlay("hide");
            },
            success:function(result){
                var data = result;
                //console.log(data);
                cod_modelo = data[0]['cod_modelo'];
                $('#modalDetalleEquipoLabel').html(codigo + '-' + data[0]['dsc_equipo']);
                $('#EstadoDetalleEquipo').html(data[0]['dsc_estado']);
                $('#tipoEquipo').val(data[0]['dsc_tipo_equipo']);
                $('#subtipoEquipo').val(data[0]['dsc_subtipo_equipo']);
                $('#marcaEquipo').val(data[0]['dsc_marca']);
                $('#modeloEquipo').val(data[0]['dsc_modelo']);
                $('#actFijoEquipo').val(data[0]['cod_activo']);
                $('#inventarioEquipo').val(data[0]['cod_inventario']);
                $('#numSerieEquipo').val(data[0]['num_serie']);
                $('#ubicacionEquipo').val(data[0]['dsc_ubicacion']);
                $('#sedeEquipo').val(data[0]['dsc_sede']);

                $.ajax({
                    type: 'GET',
                    url: "{{url('equipo/listaIntervencion')}}",
                    data: {
                        'cod_equipo' : codigo,
                        'cod_modelo' : cod_modelo
                    },
                    beforeSend: function () {
                        $("#equipo-body").LoadingOverlay("show");
                    },
                    complete: function () {
                        $("#equipo-body").LoadingOverlay("hide");
                    },
                    success:function(result){
                        var data = result;
                        //console.log(data);
                        var body  = '<div class="card-box table-responsive">';
                        // body += '<div class="row">'+'<div class="col-md-2" style="margin-bottom:0.5em;">Exportar: <img src="{{ asset("assets/images/icons/icon_excel.png") }}" title="Click para exportar" onclick="exportar()" style="height:30px;cursor:pointer;"></div>'+'</div>';
                        body += '<div class="row">'+'<div class="col-md-12" style="margin-bottom:-2em; text-align:right; margin-top:1rem;padding-right:1rem;"><ion-icon size="large" style="color:#2D8B57;vertical-align: sub;" name="ellipse"></ion-icon>Atendido &nbsp; <ion-icon size="large" style="color:#FFD603;vertical-align: sub;" name="ellipse"></ion-icon>En proceso <ion-icon size="large" style="color:#FF4601;vertical-align: sub;" name="ellipse"></ion-icon>Pendiente <ion-icon size="large" style="color:#A9A9A9;vertical-align: sub;" name="ellipse"></ion-icon>Sin orden de trabajo</div></div>';

                        body += '<table id="tbl-det-equipo" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%; font-size:16px">' +
                                    '<thead>' +
                                        '<tr class="headtable"  style="text-align:center;">' +
                                            '<th style="width:5%;">Ejec</th>' + 
                                            '<th style="width:15%;">Fecha Programado</th>' +
                                            '<th style="width:15%;">Fecha Ejecutado</th>' + 
                                            '<th style="width:10%;">Tipo Intervención</th>' +
                                            '<th style="width:40%;">Responsable</th>' +
                                            '<th style="width:5%;">Plan Asociado</th>' +
                                            '<th style="width:20%;">Orden Trabajo Asociado</th>' +
                                        '</tr>' +
                                    '</thead>' +
                                    '<tbody>';
        

                        $.each(data, function (index, value){
                            //console.log(value)
                            var colorEdo = '';
                            switch (value.dsc_estado){
                                case 'ATENDIDO':
                                    colorEdo = '#2D8B57';
                                    break;
                                case 'PENDIENTE': 
                                    colorEdo = '#FF4601';
                                    break;
                                case 'EN PROCESO': 
                                    colorEdo = '#FFD603';
                                    break;
                                case 'SIN ORDEN DE TRABAJO': 
                                    colorEdo = '#A9A9A9';
                                    break;
                            }

                            fchProg = new Date(value.fch_programacion).toLocaleDateString();
                            fchEjec = new Date(value.fch_ejecucion).toLocaleDateString();

                            body += '<tr>' + 
                                        '<td><ion-icon size="large" style="color:' + colorEdo + '" name="ellipse"></ion-icon></td>' +
                                        '<td>' + fchProg + '</td>' +
                                        '<td>' + fchEjec + '</td>' +
                                        '<td>' + value.dsc_tipo_plan + '</td>' +
                                        '<td>' + value.dsc_responsable + '</td>' +
                                        '<td style="text-align:center;">' + value.num_plan + '</td>' +
                                        '<td>' + value.cod_orden_trabajo + '</td>' +
                                    '</tr>';
                        });  
                        
                        body += '</tbody>' +
                                '</table>' +
                                '</div>';
                        
                        $('#intervencion-content').html(body);

                        $("#tbl-det-equipo").DataTable({
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
                        });
        
                        
                    }
                });
               
            }
        });
        
    }

    //Funcion para exportar a Excel
    function exportar(){

        var query = {
            'tipo'     : $("#sede").val(),
            'subtipo'  : $("#ubicacion").val()
        }

        window.location = "{{ url('equipo/exportar') }}?" + $.param(query);
    }

    
</script>
@endpush