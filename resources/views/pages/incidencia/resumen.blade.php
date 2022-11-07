@extends('layouts.refriPeruLayout')

@section('content')
   <div class="content">
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

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive titleform">
                        <h4 class="header-title headertitle"><i class="fe-clipboard"></i> Resumen</h4>
                    </div>    
                </div>    
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <div class="text-center mb-4">
                            <div class="row">
                                <div class="col-xl-3 col-sm-6">
                                    <div class="card-box widget-box-three">
                                        <div class="media">
                                            <div class="avatar-lg bg-icon rounded-circle align-self-center">
                                                <img class="avatar-sm" src="{{ asset('assets/images/icons/timeline.svg') }}" title="timeline.svg">
                                            </div>
                                            <div class="wigdet-two-content media-body">
                                                <p class="mt-1 text-uppercase font-weight-medium"  style="color:#134682;">Total</p>
                                                <h2 class="mb-2" style="color:#134682;"><span data-plugin="counterup">{{ $ctotal }}</span></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-3 col-sm-6">
                                        <div class="card-box widget-box-three">
                                                <div class="media">
                                                    <div class="avatar-lg bg-icon rounded-circle align-self-center">
                                                        <i class="fe-server font-30 text-muted avatar-title"></i>
                                                    </div>
                                                    <div class="wigdet-two-content media-body">
                                                        <p class="mt-1 text-uppercase font-weight-medium">Pendientes</p>
                                                        <h2 class="mb-2 text-danger"><span data-plugin="counterup">{{ $ctotalp }}</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                </div>

                                <div class="col-xl-3 col-sm-6">
                                        <div class="card-box widget-box-three">
                                                <div class="media">
                                                    <div class="avatar-lg bg-icon rounded-circle align-self-center">
                                                        <i class="fe-briefcase font-30 text-muted avatar-title"></i>
                                                    </div>
                                                    <div class="wigdet-two-content media-body">
                                                        <p class="mt-1 text-uppercase font-weight-medium">En proceso</p>
                                                        <h2 class="mb-2" style="color:#ffa91c;"><span data-plugin="counterup">{{ $ctotproc }}</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                </div>

                                <div class="col-xl-3 col-sm-6">
                                        <div class="card-box widget-box-three">
                                                <div class="media">
                                                    <div class="avatar-lg bg-icon rounded-circle align-self-center">
                                                        <i class="fe-download font-30 text-muted avatar-title"></i>
                                                    </div>
                                                    <div class="wigdet-two-content media-body">
                                                        <p class="mt-1 text-uppercase font-weight-medium">Atendidos</p>
                                                        <h2 class="mb-2" style="color:#32c861;"><span data-plugin="counterup">{{ $ctotatend }}</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                </div>

                                <div class="col-xl-3 col-sm-6">
                                        <div class="card-box widget-box-three">
                                                <div class="media">
                                                    <div class="avatar-lg bg-icon rounded-circle align-self-center">
                                                        <i class="fe-bar-chart-2 font-30 text-muted avatar-title"></i>
                                                    </div>
                                                    <div class="wigdet-two-content media-body">
                                                        <p class="mt-1 text-uppercase font-weight-medium">Cancelados</p>
                                                        <h2 class="mb-2" style="color:#8c9396;"><span data-plugin="counterup">{{ $ctotcanc }}</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                </div>

                            </div>

                        </div>

                    </div>    
                </div>
                
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive titleform">
                        <h4 class="header-title headertitle"><i class="fe-bar-chart"></i> Estadisticas</h4>
                    </div>    
                </div>    
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row" style="margin:1em 0;padding-left:5px;">
                        <div class="col-md-3 clasegrafico">Filtro por año:</div>
                        <div class="col-md-6">
                            <select class="form-control" id="lstfiltrouno" name="lstfiltrouno">
                                <option value="0">[seleccione año]</option>
                                @for($i = 2019; $i <= 2030; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor    
                            </select>
                        </div>   
                    </div>
                    <div class="card-box">
                        <div id="containeruno" class="contentgrafico"></div>    
                    </div>    
                </div>
                <div class="col-md-6">
                    <div class="row" style="margin:1em 0;padding-left:5px;">
                        <div class="col-md-3 clasegrafico">Filtro por año:</div>
                        <div class="col-md-6">
                            <select class="form-control" id="lstfiltrodos" name="lstfiltrodos">
                                <option value="0">[seleccione año]</option>
                                @for($j = 2019; $j <= 2030; $j++)
                                    <option value="{{ $j }}">{{ $j }}</option>
                                @endfor    
                            </select>
                        </div>   
                    </div>
                    <div class="card-box">
                        <div id="containerdos" class="contentgrafico"></div>    
                    </div>    
                </div>    
            </div>     
    </div> <!-- end container-fluid -->

    </div> <!-- end content -->
@endsection

@push('scripts')
<script type="text/javascript">

$(document).ready(function(){
    loading();

});

//Hacemos las busquedas por año:
$("#lstfiltrouno").change(function (){
    var anio = $(this).val();
    //
    $.ajax({
        url : "{{ url('incidencia/reporte/estados')}}",
        type: "get",
        data: {"anio":anio},
        beforeSend: function () {
            $("#containeruno").LoadingOverlay("show");
        },
        complete: function () {
            $("#containeruno").LoadingOverlay("hide");
        },
        success:function(result){
            var data = result;
            titulin  = data.title;
            arreglo  = data.data;

            loadingdhashboardone(titulin,anio,arreglo);
        }
    });

});
//
$("#lstfiltrodos").change(function (){
    var year = $(this).val();
    //
    $.ajax({
        url : "{{ url('incidencia/reporte/incidencia')}}",
        type: "get",
        data: {"year":year},
        beforeSend: function () {
            $("#containerdos").LoadingOverlay("show");
        },
        complete: function () {
            $("#containerdos").LoadingOverlay("hide");
        },
        success:function(result){
            var datin = result;
            titulon   = datin.title;
            array     = datin.data;

            loadingdhashboardtwo(titulon,year,array);
        }
    });

});

//funcion load
function loading(anio){
    var d    = new Date();
    var anio = d.getFullYear();     //sacamos el año actual
    //---------------------------
    var titulin;
    var arreglo  = [];
    //---------------------------
    var titulon;
    var array    = [];
    //Este es para el 1er grafico.
    $.ajax({
        url : "{{ url('incidencia/reporte/estados')}}",
        type: "get",
        data: {"anio":anio},
        beforeSend: function () {
            $("#containeruno").LoadingOverlay("show");
        },
        complete: function () {
            $("#containeruno").LoadingOverlay("hide");
        },
        success:function(result){
            var data = result;
            titulin  = data.title;
            arreglo  = data.data;

            //console.log(arreglo);

            loadingdhashboardone(titulin,anio,arreglo);
        }
    });

    //Este es para el 2do grafico.
    $.ajax({
        url : "{{ url('incidencia/reporte/incidencia')}}",
        type: "get",
        data: {"year":anio},
        beforeSend: function () {
            $("#containerdos").LoadingOverlay("show");
        },
        complete: function () {
            $("#containerdos").LoadingOverlay("hide");
        },
        success:function(result){
            var datin = result;
            titulon   = datin.title;
            array     = datin.data;

            //console.log(array);

            loadingdhashboardtwo(titulon,anio,array);
        }
    });
    
}

function loadingdhashboardone(titulin,anio,arreglo){
    //Grafico 1:
    echarts.init(document.getElementById('containeruno')).setOption(
    { 
        title: {
            text: titulin, 
            subtext: 'Año: ' + anio,
            left: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        legend: {
            left: 'center',
            top: 'bottom',
        },
        toolbox: {
            show: true,
            feature: {
                mark: {show: true},
                dataView: {show: true, readOnly: false},
                magicType: {
                    show: true,
                    type: ['pie', 'funnel']
                },
                restore: {show: true},
                saveAsImage: {show: true}
            }
        },
        series: {
            name: 'Incidente',
            type: 'pie',
            radius: [30, 110],
            center: ['50%', '50%'],
            roseType: 'area',
            data: arreglo[0]
        }
    });
}


function loadingdhashboardtwo(titulon,year,array){
    //Grafico 2:
    echarts.init(document.getElementById('containerdos')).setOption(
    { 
        color: ['#3398DB'],
        title: {
            text: titulon,         
            subtext: 'Año: ' + year,
            left: 'center'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {           
                type: 'shadow'        
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: [
            {
                type: 'category',
                data: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul','Ago','Set','Oct','Nov','Dic'],
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis: [
            {
                type: 'value'
            }
        ],
        series: [
            {
                name: 'Incidencias',
                type: 'bar',
                barWidth: '60%',
                data: array,          
            }
        ]
    });

}

</script>
@endpush
