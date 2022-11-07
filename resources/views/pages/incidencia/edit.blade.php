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
                        <h4 class="header-title headertitle"><i class="fe-file-plus"></i> editar incidente N°: {{$code}} </h4>
                    </div>    
                </div>    
            </div>     
            
            {{ Form::model($incidencia, array('route' => array('incidencia.editar', $code), 'class'=>'form-horizontal', 'id' => 'form-validation', 'method' => 'POST')) }}
            {{ csrf_field() }}
            {{ Form::hidden('cod_incidente',$code)}}

            <div class="row contenedorinputs">
                    @php
                        $fecharep = $incidencia->fch_reporte;
                        $anio     = substr($fecharep,0,4);
                        $mes      = substr($fecharep,5,2);
                        $dia      = substr($fecharep,8,2);                   

                        $fechon  = $anio.'-'.$mes.'-'.$dia;

                    @endphp
                    <div class="col-md-6">
                        <div class="card-box">
                            <!--<h4 class="header-title mb-4">Datos generales</h4>-->
                            <div class="form-group">
                                <label for="lsttipo">Tipo (*)</label>
                                <select class="form-control bordecaja" id="lsttipo" name="lsttipo">
                                    <option value="0">[seleccione tipo]</option>
                                    @foreach($tipos as $tipo)
                                    @if($tipo->cod_tipoincidente==$incidencia->cod_tipoincidente)
                                    <option value="{{$tipo->cod_tipoincidente}}" selected>{{$tipo->dsc_tipoincidente}}</option>
                                    @else
                                    <option value="{{$tipo->cod_tipoincidente}}">{{$tipo->dsc_tipoincidente}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lstsubtipo">Subtipo (*)</label>
                                <select class="form-control bordecaja" id="lstsubtipo" name="lstsubtipo">
                                    <option value="0">[seleccione sub-tipo]</option>
                                    @foreach($subtipos as $stipo)
                                    @if($stipo->cod_subtipoincidente==$incidencia->cod_subtipoincidente)
                                    <option value="{{$stipo->cod_subtipoincidente}}" selected>{{$stipo->dsc_subtipoincidente}}</option>
                                    @else
                                    <option value="{{$stipo->cod_subtipoincidente}}">{{$stipo->dsc_subtipoincidente}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fecha-reporte">Fecha reporte (*)</label>
                                <input type="date" class="form-control bordecaja" name="fecha_reporte" id="fecha_reporte">
                            </div>
                            <div class="form-group">
                                <label for="lstcliente">Cliente (*)</label>
                                <select class="form-control bordecaja" id="lstcliente" name="lstcliente">
                                    <option value="0">[seleccione cliente]</option>
                                    @foreach($clientes as $cli)
                                    @if($cli->cod_cliente==$incidencia->cod_cliente)
                                    <option value="{{$cli->cod_cliente}}" selected>{{$cli->dsc_cliente}}</option>
                                    @else
                                    <option value="{{$cli->cod_cliente}}">{{$cli->dsc_cliente}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lstlinea">Sucursal (*)</label>
                                <select class="form-control bordecaja" id="lstlinea" name="lstlinea">
                                    <option value="0">[seleccione linea]</option>
                                    @foreach($lineas as $line)
                                    @if($line->num_linea==$incidencia->num_linea)
                                    <option value="{{$line->num_linea}}" selected>{{$line->dsc_direccion}}</option>
                                    @else
                                    <option value="{{$line->num_linea}}">{{$line->dsc_direccion}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lstcontacto">Contacto (*)</label>
                                <select class="form-control bordecaja" id="lstcontacto" name="lstcontacto">
                                    <option value="0">[seleccione contacto]</option>
                                    @foreach($contactos as $cto)
                                    @if($cto->cod_contacto==$incidencia->cod_contacto)
                                    <option value="{{$cto->cod_contacto}}" selected>{{$cto->dsc_nombre.', '.$cto->dsc_apellidos}}</option>
                                    @else
                                    <option value="{{$cto->cod_contacto}}">{{$cto->dsc_nombre.', '.$cto->dsc_apellidos}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lstequipo">Equipo</label>
                                <select class="form-control bordecaja" id="lstequipo" name="lstequipo">
                                    <option value="0">[seleccione equipo]</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lstresponsable">Responsable</label>
                                <select class="form-control bordecaja" id="lstresponsable" name="lstresponsable">
                                    <option value="0">[seleccione responsable]</option>
                                    @foreach($respons as $respble)
                                    @if($respble->cod_trabajador==$incidencia->cod_trabajador)
                    <option value="{{$respble->cod_trabajador}}" selected>{{ $respble->dsc_nombres.','.$respble->dsc_apellido_paterno.' '.$respble->dsc_apellido_materno }}</option>
                                    @else
                    <option value="{{$respble->cod_trabajador}}">{{ $respble->dsc_nombres.','.$respble->dsc_apellido_paterno.' '.$respble->dsc_apellido_materno }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                                
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card-box">
                            <!--<h4 class="header-title mb-4">Otros datos</h4>-->
                            <div class="form-group">
                                <label for="titulo">Título (*)</label>
                                <input type="text" class="form-control bordecaja" name="titulo" id="titulo" placeholder="titulo" value="{{$incidencia->dsc_incidente}}">
                            </div>
                            <div class="form-group">
                                <label for="lstarea">Detalle</label>
                                <textarea name="descripcion" id="descripcion" rows="10" cols="50" class="form-control bordecaja">{{$incidencia->dsc_detalleincidente}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="lstprioridad">Prioridad (*)</label>
                                <select class="form-control bordecaja" id="lstprioridad" name="lstprioridad">
                                    <option value="0">[seleccione prioridad]</option>
                                    @foreach($prioridad as $prio)
                                    @if($prio->cod_prioridad==$incidencia->cod_prioridad)
                                    <option value="{{$prio->cod_prioridad}}" selected>{{$prio->dsc_prioridad}}</option>
                                    @else
                                    <option value="{{$prio->cod_prioridad}}">{{$prio->dsc_prioridad}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="lstestado">Estado (*)</label>
                                <select class="form-control bordecaja" id="lstestado" name="lstestado">
                                    <option value="0">[seleccione estado]</option>
                                    @foreach($estado as $state)
                                    @if($state->cod_estadoincidente==$incidencia->cod_estadoincidente)
                                    <option value="{{$state->cod_estadoincidente}}" selected>{{$state->dsc_estadoincidente}}</option>
                                    @else 
                                    <option value="{{$state->cod_estadoincidente}}">{{$state->dsc_estadoincidente}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lstcanal">Canal reporte (*)</label>
                                <select class="form-control bordecaja" id="lstcanal" name="lstcanal">
                                    <option value="0">[seleccione canal]</option>
                                    @foreach($canales as $canal)
                                    @if($canal->cod_canalreporte==$incidencia->cod_canalreporte)
                                    <option value="{{$canal->cod_canalreporte}}" selected>{{$canal->dsc_canalreporte}}</option>
                                    @else
                                    <option value="{{$canal->cod_canalreporte}}">{{$canal->dsc_canalreporte}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>          
                    </div>
                    <div class="col-12">
                        <label class="campooblig">(*) Campos obligatorios</label>    
                    </div>
                    <div class="col-12 contenedorbuttons">
                        <div class="lineabajo">
                        <button type="button" id="btn-update" class="btn btn-primario"><i class="fas fa-plus"></i> Guardar</button>
                        &nbsp;
                        <button type="button" class="btn btn-cancelar" id="btn-cancelar"><i class="fas fa-reply"></i> Cancelar</button>
                        </div>
                    </div>
                    
            </div> <!-- end row -->

            {!! Form::close() !!}

        </div> <!-- end container-fluid -->

    </div> <!-- end content -->
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        //Sacamos la fecha del reporte
        var fechareporte = '<?php echo $fechon; ?>';
        document.getElementById('fecha_reporte').value = fechareporte;

        //Hacemos uso del select2
        $("#lsttipo").select2();

        $("#lstsubtipo").select2();

        $("#lstcliente").select2();

        $("#lstlinea").select2();

        $("#lstcontacto").select2();

        $("#lstprioridad").select2();

        $("#lstequipo").select2();

        $("#lstresponsable").select2();

        $("#lstestado").select2();

        $("#lstcanal").select2();


        //Busqueda de subtipos -----------------
        $('#lsttipo').change(function(){
          var idtipo = $(this).val();
          //alert('---' + idtipo + '----');
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ url('subtipo/buscar')}}",
            type:'post',
            data:'idtipo='+ idtipo,
            cache: false,
            processData: false,
            success:function(data){
              $('#lstsubtipo').html(data);
              $('#lstsubtipo').trigger('change');
                    
            }
          });
        });

        //Busqueda del numero de linea por cliente
        $('#lstcliente').change(function(){
          var idcli = $(this).val();
          //alert('---' + idcli + '----');
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ url('clientedireccion/numlinea')}}",
            type:'post',
            data:'idcli='+ idcli,
            cache: false,
            processData: false,
            success:function(data){
              $('#lstlinea').html(data);
              $('#lstlinea').trigger('change');
                    
            }
          });
        });

        //Busqueda de contacto por cliente
        $('#lstcliente').change(function(){
          var codcli = $(this).val();
          //alert('---' + idcli + '----');
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ url('clientedireccioncontacto/contacto')}}",
            type:'post',
            data:'codcli='+ codcli,
            cache: false,
            processData: false,
            success:function(data){
              $('#lstcontacto').html(data);
              $('#lstcontacto').trigger('change');
                    
            }
          });
        });

        $("#form-validation").validate();

        $('#btn-update').on('click',function(e){
            //se valida los campos obligatorios
            var $i=0;
            if($('#lsttipo').val()=='0'){
                $i=1;
            }
            if($('#lstsubtipo').val()=='0'){
                $i=1;
            }
            if($('#fecha_reporte').val()==''){
                $i=1;
            }
            if($('#lstcliente').val()=='0'){
                $i=1;
            }
            if($('#lstlinea').val()=='0'){
                $i=1;
            }
            if($('#lstcontacto').val()=='0'){
                $i=1;
            }
            if($('#lstprioridad').val()=='0'){
                $i=1;
            }
            if($('#titulo').val()==''){
                $i=1;
            }
            if($('#lstestado').val()=='0'){
                $i=1;
            }
            if($('#lstcanal').val()=='0'){
                $i=1;
            }
            //
            if($i!=1){
                if($("#form-validation").valid()){
                    $("#form-validation").submit();
                    $("#btn-submit").attr("disabled", true);
                    //$("#clientes-body").LoadingOverlay("show");
                }
            }else{
                Swal.fire(
                'Aviso',
                'Debe ingresar los campos obligatorios',
                'warning'
                );

                return false;
            }

        });

        //boton cancelar
        $("#btn-cancelar").on('click',function(){
            window.location = "{{ url('incidencia') }}";
        });

    });

</script>
@endpush