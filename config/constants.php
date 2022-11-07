<?php
return [
    'general' => [
        'sistema' => 1,
        'tema' => 1,
    ],
    'sistema' => [
        1 => 'Gestión de incidencias',
    ],
    'temas' => [
        1 => 'refriperu',
    ],
    'status' => [
        'invalid' => 401,
        'ok' => 200,
        'error' => 500,
        'conflict' => 409
    ],
    'roles_name' => [
        'cliente' => 'Cliente',
        'trabajador' => 'Trabajador',
        'proveedor' => 'Proveedor'
    ],
    'tipo_recurso' => [
        'computadora'=> 'Computadora' ,
        'cubiculo' => 'Cubículo'
    ],
    'estado_recurso' => [
        'disponible' => 1,
        'reservado' => 2,
        'eliminado' => 3,
        'inhabilitado' => 4
    ],
    'estado_registro' => [
        'eliminado' => 0,
        'suprimido' => 1,
        'disponible' => 2
    ],
    'estado_item' => [
        'disponible' => 1,
        'prestado' => 2,
        'reservado' => 3,
        'perdido' => 4
    ],
    'modules_identifiers' => [
        'catalogacion' => 1,
        'reportes' => 2,
        'gestion_sistema' => 3,
        'usuarios' => 4,
        'publicacion_periodica' => 5
    ],
    'ruta_archivos' => [
        'base_url' => '/storage/',
        'marc_files_path' => '/app/public/',
        'marc_resource' => 'marc/data',
        'record_template' => 'marc/record-template',
        'item_template' => 'marc/item-template',
        'solicitudes_path' => 'public/solicitud',
        'record_files_path' => 'public/registros',
        'profile_path' => 'public/perfiles',
        'enlace_path' => 'public/enlaces',
        'temp_export' => 'exports'
    ],
    'formato_archivos' => [
        'pdf' => '.pdf',
        'marc' => '.mrc',
        'maatwebsite_excel' => 'xlsx',
        'maatwebsite_pdf' => 'pdf'
    ],
    'estado_incidente' => [
        'Pendiente'  => '001',
        'En_Proceso' => '002',
        'Atendido'   => '003',
        'Cancelado'  => '004'
    ],
    'prioridad_incidente' => [
        'Critico' => '001',
        'Urgente' => '002',
        'Normal'  => '003',
        'Baja'    => '004'
    ],
    'paging' => [
        'pagination_skip' => 2,
        'report_tables' => 10,
        'reserva_principal' => 5,
        'autoridad_index' => 10,
        'catalogo_index' => 8,
    ],
    'breadcrumb_items' => [
        'modules' => [
            'gestion_sistema' => [
                'title' => [
                    'url' => 'menu/gestion_sistema',
                    'name' => 'Gestión del Sistema'
                ],
                'items' => [
                    'perfil' => [
                        'url' => 'perfil',
                        'name' => 'Perfil de Usuario'
                    ],
                    'tipo_documento' => [
                        'url' => 'tipo_documento',
                        'name' => 'Tipos de Documento'
                    ],
                    'facultad' => [
                        'url' => 'facultad',
                        'name' => 'Gestión de Facultades'
                    ],
                    'reporteinventario' => [
                        'url' => 'system_report/inventario',
                        'name' => 'Gestión de Inventario'
                    ],
                    'local' => [
                        'url' => 'locales',
                        'name' => 'Gestión de Bibliotecas'
                    ],
                    'permisos' => [
                        'url' => 'permisos',
                        'name' => 'Permisos de Usuarios'
                    ],
                    'recurso' => [
                        'url' => 'recurso',
                        'name' => 'Recursos de Estudio'
                    ],
                    'tipo_usuario' => [
                        'url' => 'tipo_usuario',
                        'name' => 'Tipos de Usuario'
                    ]
                ]
            ],
            'publicacion' => [
                'title' => [
                    'url' => 'menu/publicacion',
                    'name' => 'Públicación Periódica'
                ],
                'items' => [
                    'suscripciones' => [
                        'url' => 'publicacion/suscripcion',
                        'name' => 'Suscripciones'
                    ],
                    'reclamos' => [
                        'url' => 'publicacion/reclamos',
                        'name' => 'Reclamos'
                    ]
                ]
            ],
            'reporte' => [
                'title' => [
                    'url' => 'menu/reporte',
                    'name' => 'Reportes Estadísticos'
                ],
                'items' => [
                    'catalogacion' => [
                        'url' => 'system_report/catalogacion/index',
                        'name' => 'Reporte de Catalogación'
                    ],
                    'autoridades' => [
                        'url' => 'system_report/autoridades/index',
                        'name' => 'Reporte de Autoridades'
                    ],
                    'usuarios' => [
                        'url' => 'system_report/usuarios/index',
                        'name' => 'Reporte de Usuarios'
                    ],
                    'reporte_inventario' => [
                        'url' => 'system_report/inventario',
                        'name' => 'Reporte de Inventario'
                    ],
                    'estadistica' => [
                        'url' => 'grafico/estadisticas',
                        'name' => 'Estadísticas'
                    ]
                ]
            ],
            'perfil' => [
                'title' => [
                    'url' => 'perfil',
                    'name' => 'Mis opciones'
                ],
                'items' =>[
                    'perfil' => [
                        'url' => 'perfil',
                        'name' => 'Perfil del Usuario'
                    ],
                    'reserva' => [
                        'url' => 'reserva',
                        'name' => 'Mis Reservas'
                    ]                    
                ]
            ],
            'gestion_usuarios' => [
                'title' => [
                    'url' => 'menu/usuario',
                    'name' => 'Usuarios'
                ],
                'items' => [
                    'usuario' => [
                        'url' => 'usuario/index',
                        'name' => 'Gestión de Usuarios'
                    ]
                ]
            ],
        ],
        'options' => [
            'detail' => [
                'url' => null,
                'name' => 'Detalle'
            ],
            'add' => [
                'url' => null,
                'name' => 'Crear'
            ],
            'edit' => [
                'url' => null,
                'name' => 'Editar'
            ]
        ]
    ],
    'formato_vista' => 'Cambiar formato de vista',
    'todos' => 0,
    'top_estadisticas' => 10,
    'meses' => array(1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo',
        4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio',
        8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre',
        11 => 'Noviembre', 12 => 'Diciembre'),
    'estado_civil' => array('Soltero' => 'Soltero', 'Casado' => 'Casado', 'Viudo' => 'Viudo', 'Divorciado' => 'Divorciado'),
    'tipo_adquisicion_array' => array(2 => 'Compra', 3 => 'Canje', 1 => 'Donación'),
    'genero' => array('Masculino' => 'Masculino', 'Femenino' => 'Femenino')
];
