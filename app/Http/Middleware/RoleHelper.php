<?php

namespace App\Http\Middleware;

class RoleHelper
{
    
    public static function hasAnyModule($role)  //No funciona
    {
        try{
            
            $userRoles = array(1 => "Cliente",2 => "Trabajador",3 => "Proveedor",4 => "Administrador");

            $indice   = array_search($roles,$userRoles);

            if($indice!=''){
                return true;
            }else{
                return false;
            }

        }catch (\Exception $e){
            return false;
        }
    }

    public static function hasAnyRole($roles)
    {
        try{
            $userRol = Session()->get('rol');

            if (empty($userRol))
                return false;

            if($userRol==$roles){
                return true;
            }else{
                return false;
            }

        }catch (\Exception $e){
            return false;
        }

    }

    public static function isGuest()
    {
        $user = Session()->get('usuario');

        if (empty($user))
            return true;

        return false;
    }

    /*public static function getTypeUserName()
    {
        $userTypeName = Session()->get('usuario')["tipo_usuario"];

        if (empty($userTypeName))
            return "Visitante";

        return $userTypeName;
    }

    public static function getUserName()
    {
        $userName = Session()->get('usuario')["nombre"];

        if (empty($userName))
            return "Usuario";

        return $userName;
    }

    public static function getLocalId()
    {
        $localId = Session()->get('usuario')["id_local"];

        if (empty($localId))
            return null;

        return $localId;
    }*/

}
