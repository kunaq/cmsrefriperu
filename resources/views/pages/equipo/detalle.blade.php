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

            {{-- <div class="row">
                <div class="col-12">
                    <div class="table-responsive titleform">
                        <h4 class="header-title headertitle"><i class="far fa-caret-square-down vermas" option="0"></i> Filtros</h4>
                    </div>    
                </div>    
            </div> --}}

            <div class="container" style="margin-left: 0"> {{-- clase para el filtro dinamico ==  cntfiltro --}}
                <div class="row" style="padding-bottom:15px;">
                    <div class="col-md-4">
                        <h5 class="headerh">Sede</h5>
                        <select class="form-control" id="sede" name="sede">
                            <option value="0">Todos</option>
                            @foreach($listaSede as $list)
                                <option value="{{ $list->num_linea }}">{{ $list->dsc_nombre_direccion }}</option>
                            @endforeach  
                        </select>
                    </div>
                    <div class="col-md-4">
                        <h5 class="headerh">Ubicación</h5>
                        <select class="form-control" id="ubicacion" name="ubicacion">
                            <option value="0">Todos</option>
                        </select>
                    </div>
                    <div id="ubicacion2">
                    </div> 
                    <div class="col-md-2">
                        <h5 class="headerh">&nbsp;</h5>
                        <button class="btnlimpiar btn-clear">
                            <i class="fe-rotate-cw"></i>
                        </button>
                    </div>   
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
                    $('#ubicacion').trigger('change');   
                }
            });
            //Se llama al equipo content
            $("#equipo-content").html("");
            loadPageData();
        });

        ///// aqui deberia ser cuando ubicacion cambia
        $("#ubicacion").change(function (){
            $("#ubicacion").change(function (){
            //Aqui se llama a la ubicacion2
            var linea = $('#sede').val();
            var codCliente = "{{$codCliente}}";
            var lineaSup = $('#ubicacion').val().split('+')[1];
            console.log('lineaEnSelect', lineaSup);
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
                    //$('#ubicacion2').select2();
                    $('#ubicacion2').html(data);
                    $('#ubicacion2').trigger('change'); 
                    
                    //console.log('lineaSuperior', data);  
                }
            });
            //Se llama al equipo content
            $("#equipo-content").html("");
            loadPageData();
            });
        });
        
        /////fin cambio de ubicacion..

        //here start the triggers for the filters..
        $("#ubicacion").change(function(){
            $("#equipo-content").html("");
            loadPageData();    
        });
        $("#ubicacion2").change(function(){
            $("#equipo-content").html("");
            loadPageData();    
        });
     
        $(".btn-clear").click(function(){
            window.location = "{{ url('equipo') }}";
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
            'tipo'     : $("#sede").val(),
            'subtipo'  : $("#ubicacion").val()
        }

        window.location = "{{ url('equipo/exportar') }}?" + $.param(query);
    }

    
</script>
@endpush