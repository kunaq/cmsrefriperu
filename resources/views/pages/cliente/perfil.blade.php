@extends('layouts.refriPeruLayout')

@section('content')
   <div class="content" id="perfil-body">
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
                                <li class="breadcrumb-item active">Dashboard 1</li>
                            </ol>
                        </div> --}}
                        <h4 class="page-title lineatitle"><i class="fe-file-text"></i> PERFIL DE CLIENTE</h4>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6">
                    <form class="card-box">
                        <h4 class="header-title headertitle">Datos personales</h4>

                        <div class="">
                            <label class="mb-1 mt-3 text-muted">Razon social</label>
                            <input type="text" name="razonsocial" id="razonsocial" class="form-control" value="{{$cliente->dsc_razon_social}}" disabled>
                        </div>
                        <div class="">
                            <label class="mb-1 mt-3 text-muted">N° RUC</label>
                            <input type="text" name="numruc" id="numruc" class="form-control" value="{{$cliente->dsc_documento}}" disabled/>
                        </div>
                        <div class="">
                            <label class="mb-1 mt-3 text-muted">Email</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{$clientePlus->dsc_correo}}" disabled/>
                        </div>
                        <div class="">
                            <label class="mb-1 mt-3 text-muted">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" value="{{$clientePlus->dsc_telefono1}}" disabled/>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="card-box">
                        <h4 class="header-title headertitle">Otros datos</h4>
                        <!--<p>&nbsp;</p>-->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#contacto" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                    <span class="d-none d-sm-block">Contactos</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#centro" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Centro de responsabilidad</span>
                                </a>
                            </li>
                                        
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="contacto">
                                <div id="contactos-content"></div>                    
                            </div>
                            <div class="tab-pane" id="centro">
                                <div id="centro-content"></div>                
                            </div>    
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="header-title headertitle">Mis direcciones</h4>
                        <div id="direccion-content"></div>    
                    </div>
                </div>    
            </div>

            <div class="row" id="cntotros">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="header-title headertitle">Detalle Cliente Dirección</h4>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#contactines" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                    <span class="d-none d-sm-block">Contactos por dirección</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#ubicaciones" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Ubicaciones por dirección</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="contactines">
                                <div id="contactines-content"></div>                    
                            </div>
                            <div class="tab-pane" id="ubicaciones">
                                <div id="ubicaciones-content"></div>            
                            </div>    
                        </div>

                    </div>
                </div>

            </div>
               
        </div> <!-- end container-fluid -->

    </div> <!-- end content -->
@endsection

@push('scripts')
<script type="text/javascript">

    $(document).ready(function(){
        //Sacamos el codigo del cliente: 
        var codigocli = '{{$codcli}}';

        loadPageData(codigocli);

    });

    function loadPageData(codigocli){
        //1er ajax: Listado de contactos
        $.ajax({
            type: "GET",
            url:  "{{url('cliente/contactos')}}",
            data: {
                  "codcli": codigocli,
            },
            beforeSend:function(){
                $("#contactos-content").LoadingOverlay("show");
            },
            complete:function(){
                $("#contactos-content").LoadingOverlay("hide");
            },
            success:function(result){
                var data = result;
                //console.log(data.items.length);
                if(data.items.length > 0){
                    $("#contactos-content").html(getContactosTable(data.items));

                    $("#tablecontacto").DataTable({
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
                    $("#contactos-content").html(getEmptyContent());
                }
            }
        });

        //2do ajax: Listado de centros
        $.ajax({
            type: "GET",
            url:  "{{url('cliente/centro_responsabilidad')}}",
            data: {
                  "codecli": codigocli,
            },
            beforeSend:function(){
                $("#centro-content").LoadingOverlay("show");
            },
            complete:function(){
                $("#centro-content").LoadingOverlay("hide");
            },
            success:function(result){
                var data = result;
                //console.log(data.items.length);
                if(data.items.length > 0){
                    $("#centro-content").html(getCentroResponsabilidadTable(data.items));

                    $("#tablecentro").DataTable({
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
                    $("#centro-content").html(getEmptyContent());
                }
            }
        });

        //3er ajax: Listado de clientes-dirección
        $.ajax({
            type: "GET",
            url:  "{{url('cliente/direccion')}}",
            data: {
                  "idcli": codigocli,
            },
            beforeSend:function(){
                $("#perfil-body").LoadingOverlay("show");
            },
            complete:function(){
                $("#perfil-body").LoadingOverlay("hide");
            },
            success:function(result){
                var data = result;
                //console.log(data.items.length);
                if(data.items.length > 0){
                    $("#direccion-content").html(getDireccionTable(data.items));

                    $("#tabledireccion").DataTable({
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
                    $("#direccion-content").html(getEmptyContent());
                }
            }
        });

    }

    function getContactosTable(items){
        var j = 1;
        var body = '';
        var correo,cargo;

        body +='<table id="tablecontacto" class="table table-bordered  dt-responsive nowrap" style="border-collapse:collapse; border-spacing: 0; width: 100%;">' +
               '<thead>' +
               '<tr class="headtable">' +
               '<th>N°</th>' +
               '<th>Nombres</th>' +
               '<th>Correo</th>' +
               '<th>Cargo</th>' +
               '</tr>' +
               '</thead>' +
               '<tbody>';

        $.each(items, function (index, value){
        
        if(value.correo!=null){
            correo = value.correo;
        }else{
            correo = '';
        }

        if(value.cargo!=null){
            cargo = value.cargo;
        }else{
            cargo = '';
        }

        body += '<tr>' +
                '<td>' + j + '</td>' +
                '<td>' + value.nombre + ', ' + value.apellidos + '</td>' +
                '<td>' + correo + '</td>' +
                '<td>' + cargo + '</td>' +
                '</tr>';

        j++;

        });

        body += '</tbody>' +
                '</table>';
        
        return body;          
    }

    function getCentroResponsabilidadTable(items){
        var i = 1;
        var html = '';
        var centro,estado;

        html +='<table id="tablecentro" class="table table-bordered  dt-responsive nowrap" style="border-collapse:collapse; border-spacing: 0; width: 100%;">' +
               '<thead>' +
               '<tr class="headtable">' +
               '<th>N°</th>' +
               '<th>Codigo</th>' +
               '<th>Nombre</th>' +
               '<th>Estado</th>' +
               '<th>Centro Superior</th>' +
               '</tr>' +
               '</thead>' +
               '<tbody>';

        $.each(items, function (index, value){

        if(value.nom_centro!=null){
            centro = value.nom_centro;
        }else{
            centro = '';
        }

        if(value.estado!=null){
            estado = value.estado;
        }else{
            estado = '';
        }

        html += '<tr>' +
                '<td>' + i + '</td>' +
                '<td>' + value.cod_centro + '</td>' +
                '<td>' + centro + '</td>' +
                '<td>' + estado + '</td>' +
                '<td>' + value.code_sup + '</td>' +
                '</tr>';

        i++;

        });

        html += '</tbody>' +
                '</table>';
        
        return html;
    }

    function getDireccionTable(items){
        var k = 1;
        var html = '';
        var ubicacion,referencia,direccion,codtipo,telefono;

        html +='<table id="tabledireccion" class="table table-bordered  dt-responsive nowrap" style="border-collapse:collapse; border-spacing: 0; width: 100%;">' +
               '<thead>' +
               '<tr class="headtable">' +
               '<th>N°</th>' +
               '<th>Dirección</th>' +
               '<th>Referencia</th>' +
               '<th>Tipo</th>' +
               '<th>Ubicacion</th>' +
               '<th>Teléfono</th>' +
            //    '<th>Detalle</th>' +
               '</tr>' +
               '</thead>' +
               '<tbody>';

        $.each(items, function (index, value){

        if(value.referencia!=null){
            referencia = value.referencia;
        }else{
            referencia = '';
        }

        if(value.direccion!=null){
            direccion = value.direccion;
        }else{
            direccion = '';
        }

        if(value.codtipodir!=null){
            codtipo = value.codtipodir;
        }else{
            codtipo = '';
        }

        if(value.telefono!=null){
            telefono = value.telefono;
        }else{
            telefono = '';
        }
        //
        ubicacion = value.departamento + '-' + value.provincia + '-' + value.distrito;

        html += '<tr>' +
                '<td><a class="urlicon" title="ver detalle" href="javascript::void(0)" onclick="verdetalle(' + "'" + value.codcliente + "'" + ',' + "'" + value.numlinea + "'" + ')">' + k + '</a></td>' +
                '<td>' + direccion + '</td>' +
                '<td>' + referencia + '</td>' +
                '<td>' + codtipo + '</td>' +
                '<td>' + ubicacion + '</td>' +
                '<td>' + telefono + '</td>' +
            //     '<td style="text-align:center;">' +
            // '<a class="urlicon" title="Ver detalle" href="javascript::void(0)" onclick="verdetalle(' + "'" + value.codcliente + "'" + ',' + "'" + value.numlinea + "'" + ')" >' +
            //     '<i class="fas fa-search"></i>' +
            //     '</a>' +
            //     '</td>' +
                '</tr>';

        k++;

        });

        html += '</tbody>' +
                '</table>';
        
        return html;    
    }

    //Funcion para ver detalle: direccion-contacto / ubicaciones por dirección
    function verdetalle(codecli,codelinea){
        //Hacemos aparecer la capa
        $('#cntotros').fadeIn("slow");
        $('#cntotros').css('display','inline-block');

        //1er ajax: Se trabaja con la tabla: vtade_cliente_direccion_contacto
        $.ajax({
            type: "GET",
            url:  "{{url('cliente/direccion_contacto')}}",
            data: {
                  "codecli": codecli,
                  "codelinea": codelinea,
            },
            beforeSend:function(){
                $("#cntotros").LoadingOverlay("show");      //perfil-body
            },
            complete:function(){
                $("#cntotros").LoadingOverlay("hide");
            },
            success:function(result){
                var data = result;
                //console.log(data.items.length);

                if(data.items.length > 0){
                    $("#contactines-content").html(getDireccionContactoTable(data.items));

                    $("#tablecontactines").DataTable({
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
                    $("#contactines-content").html(getEmptyContent());
                }
            }
        });

        //2do ajax: Se trabaja con la tabla: mtoma_ubicacion
        $.ajax({
            type: "GET",
            url:  "{{url('cliente/ubicacion')}}",
            data: {
                  "codecli": codecli,
                  "codelinea": codelinea,
            },
            beforeSend:function(){
                $("#ubicaciones-content").LoadingOverlay("show");
            },
            complete:function(){
                $("#ubicaciones-content").LoadingOverlay("hide");
            },
            success:function(result){
                var data = result;
                //console.log(data.items.length);
                if(data.items.length > 0){
                    $("#ubicaciones-content").html(getUbicacionDireccionTable(data.items));

                    $("#tableubicaciones").DataTable({
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
                    $("#ubicaciones-content").html(getEmptyContent());
                }
            }
        });      

    }

    function getDireccionContactoTable(items){
        var m = 1;
        var cuerpo = '';
        var name,correo,telefono,cargo;

        cuerpo +='<table id="tablecontactines" class="table table-bordered  dt-responsive nowrap" style="border-collapse:collapse; border-spacing: 0; width: 100%;">' +
               '<thead>' +
               '<tr class="headtable">' +
               '<th>N°</th>' +
               '<th>Nombres</th>' +
               '<th>Correo</th>' +
               '<th>Teléfono</th>' +
               '<th>Usuario web</th>' +
               '<th>Cargo</th>' +
               '</tr>' +
               '</thead>' +
               '<tbody>';

        $.each(items, function (index, value){
        //
        if(value.email!=null){
            correo = value.email;
        }else{
            correo = '';
        }

        if(value.phone!=null){
            telefono = value.phone;
        }else{
            telefono = '';
        }

        if(value.cargo!=null){
            cargo = value.cargo;
        }else{
            cargo = '';
        }

        name = value.name + ', ' + value.firstname;
        
        cuerpo += '<tr>' +
                  '<td>' + m + '</td>' +
                  '<td>' + name + '</td>' +
                  '<td>' + correo + '</td>' +
                  '<td>' + telefono + '</td>' +
                  '<td>' + value.usuario + '</td>' +
                  '<td>' + cargo + '</td>' +
                  '</tr>';

        m++;

        });

        cuerpo += '</tbody>' +
                  '</table>';
        
        return cuerpo;
    }


    function getUbicacionDireccionTable(items){
        var n = 1;
        var cuerpin = '';
        var ubicacion,codnivel,codsuper;

        cuerpin +='<table id="tableubicaciones" class="table table-bordered  dt-responsive nowrap" style="border-collapse:collapse; border-spacing: 0; width: 100%;">' +
               '<thead>' +
               '<tr class="headtable">' +
               '<th>N°</th>' +
               '<th>Ubicación</th>' +
               '<th>CodNivel</th>' +
               '<th>CodUbicacionSup</th>' +
               '<th>Responsable</th>' +
               '</tr>' +
               '</thead>' +
               '<tbody>';

        $.each(items, function (index, value){
        //
        if(value.ubicacion!=null){
            ubicacion = value.ubicacion;
        }else{
            ubicacion = '';
        }

        if(value.codnivel!=null){
            codnivel = value.codnivel;
        }else{
            codnivel = '';
        }

        if(value.codubsup!=null){
            codsuper = value.codubsup;
        }else{
            codsuper = '';
        }

        cuerpin += '<tr>' +
                   '<td>' + n + '</td>' +
                   '<td>' + ubicacion + '</td>' +
                   '<td>' + codnivel + '</td>' +
                   '<td>' + codsuper + '</td>' +
                   '<td>' + value.nombres + '</td>' +
                   '</tr>';

        n++;

        });

        cuerpin += '</tbody>' +
                  '</table>';
        
        return cuerpin;    
    }

    //No se encontraron registros
    function getEmptyContent(mensaje = "No se encontraron registros"){
    return "<div class=\"row\" style=\"padding-top: 10px;\">" +
           "<div class=\"col-12\">" +
           "<div class=\"alert alert-info text-center\">" + mensaje + "</div>" +
           "</div>" +
           "</div>";
    }

</script>
@endpush