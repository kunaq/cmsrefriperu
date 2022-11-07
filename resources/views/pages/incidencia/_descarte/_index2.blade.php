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
                                <li class="breadcrumb-item active">Dashboard 1</li>
                            </ol>
                        </div>
                        <h4 class="page-title lineatitle"><i class="fe-file-text"></i> GESTIÓN DE INCIDENTES</h4>
                    </div>
                </div>
            </div>

            <div class="row fondoheader" style="padding-top:1em;">
                <div class="col-12">
                    <div class="card-box">
                        <button type="button" id="btn-agregar" class="btn btn-primario"><i class="fas fa-plus"></i> Agregar</button>   
                    </div>    
                </div>
            </div>

            <div class="row fondoheader" style="padding-left:12px;">
                <!--<div class="cntbotonessearch">-->
                    <div class="col-md-3">
                        <h5 class="headerh">Cliente</h5>
                        <input type="text" class="form-control" id="text-filter" placeholder="Cliente"  />
                    </div>
                    <div class="col-md-3">
                        <h5 class="headerh">Estado</h5>
                        <select class="form-control" style="width:100%;" id="estado" name="estado">
                            <option value="0">Todos</option>
                            @foreach($estados as $state)
                            <option value="{{ $state->cod_estadoincidente }}">{{ $state->dsc_estadoincidente }}</option>
                            @endforeach        
                        </select>
                    </div>
                    <div class="col-md-2">
                        <h5 class="headerh">F. Inicio</h5>
                        <input type="date" class="form-control" id="fecha_ini"  />
                    </div>
                    <div class="col-md-2">
                        <h5 class="headerh">F. Fin</h5>
                        <input type="date" class="form-control" id="fecha_hasta"  />
                    </div>
                    <div class="col-md-1">
                        <h5 class="headerh">&nbsp;</h5>
                        <button class="btnbuscar btn-search">
                            <i class="fe-search"></i>
                        </button>
                    </div>
                <!--</div>-->    
            </div>

            <div class="row fondocabecera">
                <div class="col-12">
                    <div class="table-responsive titleform">
                        <h4 class="header-title headertitle"><i class="fe-copy"></i> Listado de incidentes</h4>
                    </div>    
                </div>
                <div class="col-12">
                    <div id="incidente-content">

                    <div class="card-box table-responsive">
                            <table id="datatable" class="table table-bordered  dt-responsive nowrap" style="border-collapse:collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr class="headtable">
                                    <th>N°</th>
                                    <th>Tipo</th>
                                    <th>Titulo</th>
                                    <th>Fecha reporte</th>
                                    <th>Cliente</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $j=1;
                                @endphp

                                @foreach($incidencias as $incident)

                                @php
                                $fecha = $incident->fch_reporte;
                                $anio  = substr($fecha,0,4);
                                $mes   = substr($fecha,5,2);
                                $dia   = substr($fecha,8,2);
                                //
                                $fechrep = $dia.'-'.$mes.'-'.$anio;

                                //Trabajamos con el cliente:
                                $rsocial = $incident->dsc_razon_social;
                                $longt   = strlen($rsocial);
                                $part    = substr($rsocial, 0, 30);

                                if ($longt > 30) {
                                    $razon_social = $part . '...';
                                } else {
                                    $razon_social = $rsocial;
                                }   

                                @endphp 
                                <tr>
                                    <td>@php echo $j; @endphp</td>
                                    <td>{{$incident->dsc_tipoincidente}}</td>
                                    <td>{{$incident->dsc_incidente}}</td>
                                    <td>@php echo $fechrep; @endphp</td>
                                    <td>@php echo $razon_social; @endphp</td>
                                    <td>{{$incident->dsc_prioridad}}</td>
                                    <td>{{$incident->dsc_estadoincidente}}</td>
                                    <td style="text-align:center;">
                                        <a class="urlicon" title="Editar" href="{{url('incidencia/editar/'.$incident->cod_incidente)}}" >
                                            <i class="fas fa-edit"></i>
                                        </a>&nbsp;
                                        <a href="javascript::void(0)" class="urlicon" title="Eliminar" onclick="eliminar('{{$incident->cod_incidente}}')" >
                                            <i class="fas fa-trash-alt"></i>
                                        </a>    
                                    </td>
                                </tr>
                                @php
                                $j++;
                                @endphp
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>

                    </div>
                </div>
            </div> <!-- end row -->

        </div> <!-- end container-fluid -->

    </div> <!-- end content -->
@endsection

@push('scripts')
<script type="text/javascript">
    //Se inicializa el dataTable
    $('#datatable').DataTable({
        pageLength: 20,
        ordering:  false
        
    });

    

    $(document).ready(function(){

        $('#estado').select2();

        //Se inicia con la funcion onload
        function loadPageData(){
            $.ajax({
                type: 'GET',
                url: "{{url('incidencia/listar')}}",
                data: {
                    'idstate': $("#estado").val(),
                    'search' : $("#text-filter").val()
                },
                beforeSend: function () {
                    $("#incidencia-body").LoadingOverlay("show");
                },
                complete: function () {
                    $("#incidencia-body").LoadingOverlay("hide");
                },
                success:function(result){
                    var data = result.data;

                    /*if(data.items.length > 0){
                        $("#incidente-content").html(getIncidenciaTable(data.items));
                    }else{
                        $("#incidente-content").html(getEmptyContent());
                    }*/
                }
            });    
        }

        /*function getIncidenciaTable(items){

        }*/

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

    });

</script>
@endpush
