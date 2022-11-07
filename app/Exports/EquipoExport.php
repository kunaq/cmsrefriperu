<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Equipo;
use App\Models\TipoEquipo;
use App\Models\SubTipoEquipo;
use App\Models\Marca;
use App\Models\Modelo;

use Illuminate\Support\Facades\DB;

//Se llama a las clases de Excel
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;

class EquipoExport implements FromCollection, WithHeadings,ShouldAutoSize,WithEvents{

	/**
    * @return \Illuminate\Support\Collection
    */

    /**
     * @return array
    */

	public function __construct($numserie,$tipo,$subtipo,$nomequipo,$codmarca,$codmodel) {
        $this->numserie  = $numserie;
        $this->tipo      = $tipo;
        $this->subtipo   = $subtipo;
        $this->nomequipo = $nomequipo;
        $this->codmarca  = $codmarca;
        $this->codmodel  = $codmodel;
    }

 	public function collection(){ 

		$equipos   = DB::table('gsema_equipo as equipo')
                     ->join('gsema_tipo_equipo','equipo.cod_tipo_equipo', '=', 'gsema_tipo_equipo.cod_tipo_equipo')
                     ->join('gsema_subtipo_equipo','equipo.cod_subtipo_equipo', '=', 'gsema_subtipo_equipo.cod_subtipo_equipo')
                     ->join('feima_marca_articulo','equipo.cod_marca', '=', 'feima_marca_articulo.cod_marca')
                     ->leftJoin('feima_modelo_articulo','equipo.cod_modelo', '=', 'feima_modelo_articulo.cod_modelo')
                     ->select('equipo.cod_equipo','gsema_tipo_equipo.dsc_tipo_equipo','gsema_subtipo_equipo.dsc_subtipo_equipo',
                              'feima_marca_articulo.dsc_marca','feima_modelo_articulo.dsc_modelo','equipo.dsc_equipo','equipo.num_serie',
                              'equipo.num_parte','equipo.fch_compra','equipo.num_pedido');

        if (!empty($this->numserie))
            $equipos = $equipos->where('equipo.num_serie', 'like', '%' . $this->numserie . '%');

        if (!empty($this->tipo))
            $equipos = $equipos->where('equipo.cod_tipo_equipo', '=', $this->tipo);

        if (!empty($this->subtipo))
            $equipos = $equipos->where('equipo.cod_subtipo_equipo', '=', $this->subtipo);

        if (!empty($this->nomequipo))
            $equipos = $equipos->where('equipo.dsc_equipo', 'like', '%' . $this->nomequipo . '%');

        if (!empty($this->codmarca))
            $equipos = $equipos->where('equipo.cod_marca', '=', $this->codmarca);

        if (!empty($this->codmodel))
            $equipos = $equipos->where('equipo.cod_modelo', '=', $this->codmodel);

            $equipos = $equipos
                   ->orderBy('equipo.dsc_equipo')
                   ->get();

		return $equipos;

	}

	public function headings(): array
    {
        return [
            'Codigo',
            'Tipo',
            'Sub-tipo',
            'Marca',
            'Modelo',
            'Nombre',
            'N° Serie',
            'N° Parte',
            'Fecha compra',
            'N° Pedido'
        ];
    }
    
	
	public function registerEvents(): array{	

    	$cellRange = 'A1:J1';
	    Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
	    	$sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
		});

		return [
                      
			AfterSheet::class    => function(AfterSheet $event) {
               
                $event->sheet->styleCells(
                    'A1:J1',
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
