<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Incidencia;
use App\Models\TipoIncidente;
use App\Models\Cliente;
use App\Models\PrioridadIncidente;
use App\Models\EstadoIncidente;
use App\Models\CanalReporte;
use App\Models\Responsable;

use Illuminate\Support\Facades\DB;

//Se llama a las clases de Excel
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;

class IncidenciaExport implements FromCollection, WithHeadings,ShouldAutoSize,WithEvents{

	/**
    * @return \Illuminate\Support\Collection
    */

    /**
     * @return array
    */

	public function __construct($idstate,$search,$fdesde,$fhasta,$codresp,$codeinc) {
        $this->idstate  = $idstate;
        $this->search   = $search;
        $this->fdesde   = $fdesde;
        $this->fhasta   = $fhasta;
        $this->codresp  = $codresp;
        $this->codeinc  = $codeinc;
    }

 	public function collection(){ //DB::raw('CONCAT(rhuma_trabajador.dsc_nombres, rhuma_trabajador.dsc_apellido_paterno, rhuma_trabajador.dsc_apellido_materno)')

		$incidencias  = DB::table('mtoca_incidente as incidente')
                        ->join('mtoma_tipoincidente','incidente.cod_tipoincidente', '=', 'mtoma_tipoincidente.cod_tipoincidente')
					    ->join('mtoma_subtipoincidente','incidente.cod_subtipoincidente', '=', 'mtoma_subtipoincidente.cod_subtipoincidente')
					    ->join('mtoma_canalreporte','incidente.cod_canalreporte', '=', 'mtoma_canalreporte.cod_canalreporte')
                        ->join('vtama_cliente','incidente.cod_cliente', '=', 'vtama_cliente.cod_cliente')
                        ->join('mtoma_prioridadincidente','incidente.cod_prioridad', '=', 'mtoma_prioridadincidente.cod_prioridad')
                        ->join('mtoma_estado_incidente','incidente.cod_estadoincidente', '=', 'mtoma_estado_incidente.cod_estadoincidente')
                        ->leftJoin('rhuma_trabajador','incidente.cod_trabajador', '=', 'rhuma_trabajador.cod_trabajador')
                        ->select('incidente.cod_incidente','mtoma_tipoincidente.dsc_tipoincidente','mtoma_subtipoincidente.dsc_subtipoincidente',
                      	       'incidente.dsc_incidente','incidente.dsc_detalleincidente','incidente.fch_reporte','vtama_cliente.dsc_razon_social',
                               'mtoma_prioridadincidente.dsc_prioridad','mtoma_estado_incidente.dsc_estadoincidente','mtoma_canalreporte.dsc_canalreporte',
                               //DB::raw(('rhuma_trabajador.dsc_nombres + rhuma_trabajador.dsc_apellido_paterno'))
                               DB::raw(('rhuma_trabajador.dsc_nombres,rhuma_trabajador.dsc_apellido_paterno,rhuma_trabajador.dsc_apellido_materno'))
                        );

        
        if (!empty($this->codeinc))
        $incidencias = $incidencias->where('incidente.cod_incidente', '=', $this->codeinc);

        if (!empty($this->idstate))
        $incidencias = $incidencias->where('incidente.cod_estadoincidente', '=', $this->idstate);

    	if (!empty($this->codresp))
        $incidencias = $incidencias->where('incidente.cod_trabajador', '=', $this->codresp);

    	if (!empty($this->search))
        $incidencias = $incidencias->where('vtama_cliente.dsc_razon_social', 'like', '%' . $this->search . '%');

    	if (!empty($this->fdesde) && !empty($this->fhasta))
         $incidencias = $incidencias->whereBetween('incidente.fch_reporte', array($this->fdesde, $this->fhasta));

    	$incidencias = $incidencias

					->orderBy('incidente.dsc_incidente')
                    ->get();

		return $incidencias;

	}

	public function headings(): array
    {
        return [
            'Codigo',
            'Tipo',
            'Sub-tipo',
            'Titulo',
            'Detalle',
            'Fecha-reporte',
            'Cliente',
            'Prioridad',
            'Estado',
            'Canal-reporte',
            'Responsable'
        ];
    }
    
	
	public function registerEvents(): array{	

    	$cellRange = 'A1:M1';
	    Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
	    	$sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
		});

		return [
                      
			AfterSheet::class    => function(AfterSheet $event) {
               
                $event->sheet->styleCells(
                    'A1:M1',
                    [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                        'font' => [
					         'name' => 'Century Gothic',
					         'size' => 14,
					         'bold' => true,
					         'color' => ['argb' => '000000'],
					    ],
					    'background'=>[
					    	'color' => ['argb' => '000000'],
					    ],
                    ]
                );
            },
        ];
    }

}
