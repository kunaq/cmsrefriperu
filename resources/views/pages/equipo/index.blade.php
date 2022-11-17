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
                <div class="col-md-4">
                    <h5 class="headerh">N° Serie</h5>
                    <input type="text" class="form-control bordecaja" name="numserie" id="numserie" placeholder="N° Serie" maxlength="50" />
                </div>
                <div class="col-md-4">
                    <h5 class="headerh">Tipo</h5>
                    <select class="form-control" id="tipo" name="tipo">
                        <option value="0">Todos</option>
                        @foreach($tipos as $type)
                            <option value="{{ $type->cod_tipo_equipo }}">{{ $type->dsc_tipo_equipo }}</option>
                        @endforeach  
                    </select>
                </div>
                <div class="col-md-4">
                    <h5 class="headerh">Sub-tipo</h5>
                    <select class="form-control" id="sub-tipo" name="sub-tipo">
                        <option value="0">Todos</option>
                    </select>
                </div>    
            </div>

            <div class="row fondoheader">
                <!--<div class="cntbotonessearch">-->
                    <div class="col-md-4">
                        <h5 class="headerh">Nombre</h5>
                        <input type="text" class="form-control bordecaja" name="nomequipo" id="nomequipo" placeholder="Nombre de equipo" maxlength="100"  />
                    </div>
                    <div class="col-md-3">
                        <h5 class="headerh">Marca</h5>
                        <select class="form-control" id="marca" name="marca">
                            <option value="0">Todos</option>
                            @foreach($marcas as $marca)
                                <option value="{{ $marca->cod_marca }}">{{ $marca->dsc_marca }}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="col-md-3">
                        <h5 class="headerh">Modelo</h5>
                        <select class="form-control" id="modelo" name="modelo">
                            <option value="0">Todos</option>
                            @foreach($modelos as $modelo)
                                <option value="{{ $modelo->cod_modelo }}">{{ $modelo->dsc_modelo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
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
                        <h4 class="header-title headertitle"><i class="fe-copy"></i> Listado de equipos</h4>
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
    function soloNumeros(e){
        var key = window.Event ? e.which : e.keyCode
        return ((key >= 48 && key <= 57) || (key==8) || (key==45) )
    }

    $(document).ready(function(){
        //Combitos
        $('#tipo').select2();

        $('#sub-tipo').select2();

        $('#marca').select2();

        $('#modelo').select2();

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

        
        $("#tipo").change(function (){
            //Aqui se llama al subtipo
            var idtipo = $(this).val();
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : "{{ url('tipoequipo/buscarsubtipo')}}",
                type: "post",
                data: "code=" + idtipo,
                cache: false,
                processData: false,
                success:function(data){
                    $('#sub-tipo').html(data);
                    $('#sub-tipo').trigger('change');   
                }
            });
            //Se llama al equipo content
            $("#equipo-content").html("");
            loadPageData();
        });

        $("#sub-tipo").change(function(){
            $("#equipo-content").html("");
            loadPageData();    
        });

        $("#marca").change(function(){
            $("#equipo-content").html("");
            loadPageData();    
        });

        $("#modelo").change(function(){
            $("#equipo-content").html("");
            loadPageData();    
        });

        $("#numserie").keypress(function (e){ //text-filter
            var key    = e.which;
            var filtro = $(this).val();
            var len    = filtro.length;
            if(key === 13){
              if(len>2){
                  $("#equipo-content").html("");
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

        $("#nomequipo").keypress(function(e){   //text-code
            var tecla = e.which;
            var code  = $(this).val();
            var long  = code.length;
            if(tecla === 13){
                if(long>2){
                    $("#equipo-content").html("");
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

        
        $(".btn-clear").click(function(){
            window.location = "{{ url('equipo') }}";
        });

        loadPageData();

    });

    //Se inicia con la funcion onload
    function loadPageData(){
        $.ajax({
            type: 'GET',
            url: "{{url('equipo/listar')}}",
            data: {
                'numserie' : $("#numserie").val(),
                'tipo'     : $("#tipo").val(),
                'subtipo'  : $("#sub-tipo").val(),
                'nomequipo': $("#nomequipo").val(),
                'codmarca' : $("#marca").val(),
                'codmodel' : $("#modelo").val()
            },
            beforeSend: function () {
                $("#equipo-body").LoadingOverlay("show");
            },
            complete: function () {
                $("#equipo-body").LoadingOverlay("hide");
            },
            success:function(result){
                var data = result;
               // console.log(data.items.length);
                if(data.items.length > 0){
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
            
        body += '<table id="tbl-equipo" class="table table-bordered dt-responsive nowrap" style="border-collapse:collapse; border-spacing:0; width:100%;">' +
                    '<thead>' +
                    '<tr class="headtable">' +
                    '<th>N°</th>' + 
                    '<th>Codigo</th>' +
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
                    '<td>' + value.nombre + '</td>' +
                    '<td>' + value.nomtipo + '</td>' +
                    '<td>' + value.nomsubtipo + '</td>' +
                    '<td>' + value.marca + '</td>' +
                    '<td>' + value.modelo + '</td>' +
                    '<td style="text-align:center;">' +
                    '<a class="urlicon" title="Ver detalle" href="javascript:void(0)" onclick="verdetalle(' + "'" + value.code + "'" + ')" >' +
                    '<i class="dripicons-search"></i>' +
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
               // console.log(data);
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
                       // body += '<div class="row">'+'<div class="col-md-8 col-md-offset-md-4" style="margin-bottom:0.5em;">Exportar: </div>'+'</div>';

                        body += '<table id="tbl-det-equipo" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%; font-size:16px">' +
                                    '<thead>' +
                                        '<tr class="headtable"  style="text-align:center;">' +
                                            '<th style="vertical-align:middle; width:5%;">Ejec</th>' + 
                                            '<th style="width:10%;">Fecha Programado</th>' +
                                            '<th style="width:10%;">Fecha Ejecutado</th>' + 
                                            '<th style="width:5%;">Tipo Intervención</th>' +
                                            '<th style="vertical-align:middle; width:20%;">Responsable</th>' +
                                            '<th style="width:5%;">Plan Asociado</th>' +
                                            '<th style="width:15%;">Orden Trabajo Asociado</th>' +
                                        '</tr>' +
                                    '</thead>' +
                                    '<tbody>';
        

                        $.each(data, function (index, value){
                            console.log(value)
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

                            //fchProg = date('d/m/Y', strtotime(value.fecha1));

                            body += '<tr>' + 
                                        '<td><ion-icon size="large" style="color:' + colorEdo + '" name="ellipse"></ion-icon></td>' +
                                        '<td>' + fchProg + '</td>' +
                                        '<td>' + value.fch_ejecucion + '</td>' +
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
            'numserie' : $("#numserie").val(),
            'tipo'     : $("#tipo").val(),
            'subtipo'  : $("#sub-tipo").val(),
            'nomequipo': $("#nomequipo").val(),
            'codmarca' : $("#marca").val(),
            'codmodel' : $("#modelo").val(),
        }

        window.location = "{{ url('equipo/exportar') }}?" + $.param(query);
    }

    
</script>
@endpush