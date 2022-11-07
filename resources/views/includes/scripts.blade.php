<script src="{{ asset('assets/js/vendor.min.js') }}" type="text/javascript"></script>


<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/libs/datatables/dataTables.responsive.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/libs/datatables/responsive.bootstrap4.min.js') }}" type="text/javascript"></script>

<!-- Buttons examples -->
<script src="{{ asset('assets/libs/datatables/dataTables.buttons.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/libs/jszip/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/libs/datatables/buttons.html5.min.js') }}" type="text/javascript"></script>

<!--  -->
<script src="{{ asset('assets/js/pages/datatables.init.js') }}" type="text/javascript"></script>

<!-- select2 js -->
<script src="{{ asset('assets/libs/select2/select2.min.js') }}" type="text/javascript"></script>

<!-- sweetalert 2 js -->
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

<!-- Jquery validate -->
<script src="{{asset('assets/libs/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/libs/jquery-validation/js/additional-methods.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/libs/jquery-validation/js/localization/messages_es_PE.js')}}" type="text/javascript"></script>

<!-- overlay load -->
<script src="{{asset('assets/libs/overlay/loadingoverlay.min.js')}}" type="text/javascript"></script>

<!-- Graficos  -->
<script src="{{asset('assets/libs/echarts/echarts.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/pages/dashboard.init.js')}}" type="text/javascript"></script>

<script src="{{ asset('assets/js/app.min.js') }}" type="text/javascript"></script>

@include('sweetalert::alert')

@yield('scripts')
@stack('scripts')