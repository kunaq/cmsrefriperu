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
                        <h4 class="page-title"><i class="fe-airplay"></i> Listado de equipos</h4>
                    </div>
                </div>
            </div>     
       
            <div class="row">
                <div class="col-12">
                    <div class="card-box table-responsive">
                            <p class="sub-header">
                                <button type="button" id="btn-agregar" class="btn btn-primario"><i class="fas fa-plus"></i> Agregar</button>   
                            </p>

                            <table id="datatable" class="table table-bordered  dt-responsive nowrap" style="border-collapse:collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr class="headtable">
                                    <th>N°</th>
                                    <th>Codigo</th>
                                    <th>Descripción</th>
                                    <th>Observacion</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                               <tr>
                                   <td>1</td>
                                   <td>C00001</td>
                                   <td>Data</td>
                                   <td>Obs</td>
                                   <td>Ocupado</td>
                                   <td>Eliminar</td>
                               </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end row -->

        </div> <!-- end container-fluid -->

    </div> <!-- end content -->
@endsection

@push('scripts')
<script type="text/javascript">
 

</script>
@endpush
