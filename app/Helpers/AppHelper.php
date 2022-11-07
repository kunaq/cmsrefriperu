<?php

namespace App\Helpers;

use App\Models\ItemSubcampos;
use Illuminate\Support\Facades\DB;

class AppHelper
{
    public static function custom_is_int($input)
    {
        //input must be a string
        if ($input[0] == '-')
            return ctype_digit(substr($input, 1));

        return ctype_digit($input);
    }

    public static function esConfigurador($request)
    {
        $roles = $request->user()->roles()->pluck('name');
        $esConfigurador = 0;

        if(in_array("Administrador", $roles->toArray()))
        {
            if ($request->user()->configurador)
                $esConfigurador = 1;
        }

        return $esConfigurador;
    }

    public static function getAdminPrivileges($usuarioId)
    {
        return DB::table('admin_local as a')
            ->select('a.id_local')
            ->where('a.id_usuario', '=', $usuarioId)
            ->pluck('id_local')
            ->toArray();
    }

    public static function getItemsQuantity($recordId)
    {
        return DB::table('registro')
            ->join('item', 'item.id_registro', '=', 'registro.id' )
            ->where('registro.id', '=', $recordId)
            ->count();
    }

    public static function esItemParaPrestamoEnCasa($itemId)
    {
        $restriccion = ItemSubcampos::where('id_item', '=', $itemId)
            ->where('code', '=', '7')
            ->select('data')
            ->first();

        if ($restriccion == null)
            return 0;

        return $restriccion->data;
    }

    public static function updateItemState($itemId, $estado)
    {
        $restriccion = ItemSubcampos::where('id_item', '=', $itemId)
            ->where('code', '=', '1')
            ->firstOrFail();

        $restriccion->data = $estado;
        $restriccion->save();
    }

    public static function updatePrestamosItemsQuantity($itemId, $fechaInicioPrestamo)
    {
        $subcampo = ItemSubcampos::where('id_item', '=', $itemId)
            ->where('code', '=', 'l')
            ->first();

        //Cantidad de prestamos
        if ($subcampo != null)
        {
            $quantity = DB::table('prestamo_item')
                ->where('prestamo_item.id_item', '=', $itemId)
                ->count();

            $subcampo->data = $quantity;
            $subcampo->save();

            $subcampoFecha = ItemSubcampos::where('id_item', '=', $itemId)
                ->where('code', '=', 's')
                ->first();

            //Fecha de ultimo prestamo
            if ($subcampoFecha != null)
            {
                $subcampoFecha->data = $fechaInicioPrestamo;
                $subcampoFecha->save();
            }
            else
            {
                ItemSubcampos::create([
                    'code' => 's',
                    'data' => $fechaInicioPrestamo,
                    'id_item' => $itemId
                ]);
            }
        }
    }

    public static function updateRenovacionItemsQuantity($itemId)
    {
        $subcampo = ItemSubcampos::where('id_item', '=', $itemId)
            ->where('code', '=', 'm')
            ->first();

        if ($subcampo != null)
        {
            $quantity = DB::table('renovacion_item')
                ->join('prestamo_item', 'prestamo_item.id', '=', 'renovacion_item.id_prestamo')
                ->where('prestamo_item.id_item', '=', $itemId)
                ->count();

            $subcampo->data = $quantity;
            $subcampo->save();
        }
    }


    public static function clientFormat($rsocial){
        
        $longt   = strlen($rsocial);
        $part    = substr($rsocial, 0, 30);

        if ($longt > 30) {
            $razon_social = $part . '...';
        } else {
            $razon_social = $rsocial;
        }

        return $razon_social;
    }

}
