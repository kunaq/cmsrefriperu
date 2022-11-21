<div class="container-fluid">
                        <div id="navigation">
                            <!-- Navigation Menu-->
                            <ul class="navigation-menu">

                                {{-- <li class="has-submenu">
                                    <a href="{{url('home')}}"><i class="fe-bar-chart-2"></i>Dashboard</a>
                                </li> --}}

                                @if(RoleHelper::hasAnyRole(config('constants.roles_name.cliente')))
                                    <li class="has-submenu">
                                    <a href="{{url('cliente/perfil')}}"><i class="fe-user"></i>Perfil de cliente</a>
                                    </li>
                                @endif

                                <li class="has-submenu">
                                    <a href="#"> <i class="fe-airplay"></i>Equipos</a>
                                    <ul class="submenu">
                                        <li><a href="{{url('equipo')}}">Listado de equipos</a></li>
                                        <!--<li><a href="index.html">Agregar equipos</a></li>-->
                                        <li><a href="{{url('equipo/detalle')}}">Listado de ubicaciones</a></li>
                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="#"> <i class="fe-file-text"></i>Incidentes</a>
                                    <ul class="submenu">
                                        <li><a href="{{url('incidencia')}}">Listado de incidentes</a></li>
                                        <li><a href="{{url('incidencia/crear')}}">Agregar incidente</a></li>
                                        <li><a href="{{url('incidencia/resumen')}}">Resumen de incidentes</a></li>
                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="#"> <i class="fe-box"></i>Procesos</a>
                                    <ul class="submenu">
                                        <li><a href="{{url('ciclo/procedure')}}">Cronograma de mantenimiento</a></li>
                                    </ul>
                                </li>

                                {{-- <li class="has-submenu">
                                    <a href="#"> <i class="fe-settings"></i>Configuración</a>
                                    <ul class="submenu">
                                        <li><a href="index.html">Cronograma de mantenimiento</a></li>
                                    </ul>
                                </li> --}}

                                
                            </ul>
                            <!-- End navigation menu -->

                            <div class="clearfix"></div>
                        </div>
                        <!-- end #navigation -->
</div>