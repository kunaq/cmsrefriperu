@extends('layouts.authLayout')

@section('content')

    <div class="account-pages w-100 mt-5 mb-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mb-0">

                        <div class="card-body p-4">

                            <div class="account-box">
                                <div class="account-logo-box">
                                    <div class="text-center">
                                        <a href="index.html">
                                            <img src="{{ asset('assets/images/logo-refriperu.png') }}" alt="" height="50"> 
                                        </a>
                                    </div>
                                    <!--<h5 class="text-uppercase mb-1 mt-4">Sign In</h5>-->
                                    <p class="mb-0" style="text-align:center;">Bienvenidos al gestor de contenidos</p>
                                </div>

                                <div class="account-content mt-4">
                                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                         @csrf

                                        <div class="form-group row">
                                            <div class="col-12">
                                             <label for="rol">Rol:</label>
                                             <select name="lstrol" class="form-control" id="lstrol">
                                                 <option value="0">[Seleccione rol]</option>
                                                 <option value="1">Cliente</option>
                                                 <option value="2">RefriPerú</option>
                                                 <!--<option value="3">Proveedor</option>-->
                                             </select>   
                                            </div>    
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-12">
                                            <label for="ruc">RUC:</label>

                                            <input id="ruc" type="text" maxlength="11" class="form-control @error('ruc') is-invalid @enderror" name="ruc" value="{{ old('ruc') }}" required autocomplete="ruc" autofocus placeholder="Ingrese RUC" onKeyPress="return soloNumeros(event)">

                                            @error('ruc')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                            </div>    
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-12">
                                            <label for="user">Usuario:</label>

                                            <input id="user" type="text" class="form-control @error('user') is-invalid @enderror" name="user" value="{{ old('user') }}" required autocomplete="user" autofocus placeholder="Ingrese usuario">

                                            @error('user')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                            </div>    
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label for="password">Contraseña:</label>

                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Ingrese password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-12">

                                                <!--<div class="checkbox checkbox-success">
                                                 
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                        <label class="form-check-label" for="remember">
                                                            Recuerdame
                                                        </label>
                                                    </div>

                                                </div>-->
                                                <input id="msg" type="hidden" class="form-control @error('msg') is-invalid @enderror" name="msg" autocomplete="current-msg">

                                                @error('msg')
                                                <span class="invalid-feedback" role="alert" style="text-align:center;">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="form-group row text-center mt-2">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-md btn-block btn-primario waves-effect waves-light">
                                                    Ingresar
                                                </button>
                                            </div>
                                        </div>

                                    </form>

                                
                                    <!--<div class="row mt-4 pt-2">
                                        <div class="col-sm-12 text-center">
                                        <p class="text-muted mb-0">No tienes cuenta? <a href="page-register.html" class="text-dark ml-1"><b>registrate</b></a></p>
                                        </div>
                                    </div>-->

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
    </div>


@endsection

@push('css')
<style type="text/css">
    body{background:#d92c28;background-repeat:no-repeat;background-size:cover;}    
</style>
@endpush

@push('scripts')
<script type="text/javascript">

//solo numeros
function soloNumeros(e){
    var key = window.Event ? e.which : e.keyCode
    return ((key >= 48 && key <= 57) || (key==8) || (key==45) )
} 

</script>
@endpush