<meta charset="UTF-8">
<title>REFRIPERU | Gestor de contenidos</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
<meta content="Coderthemes" name="author" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- App favicon -->
<link rel="shortcut icon" href="{{asset('images/pages/favicon.png')}}">

<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"  id="bootstrap-stylesheet" />
<link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css"  id="app-stylesheet" />
<link href="{{asset('assets/css/estilo.css')}}" rel="stylesheet" type="text/css"  />

<!-- css datatable -->
<link href="{{asset('assets/libs/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables/responsive.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables/searchPanes.dataTables.min.css')}}" rel="stylesheet" type="text/css" />

<!-- css select2 -->
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />

<!--<link href="https://www.selectiva.pe/assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="https://www.selectiva.pe/assets/vendors/select2/dist/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />-->

<!-- css sweetalert -->
<!--<link href="{{asset('assets/libs/alerta/sweetalert.css')}}" rel="stylesheet" type="text/css"  />-->


@yield('css')
@stack('css')