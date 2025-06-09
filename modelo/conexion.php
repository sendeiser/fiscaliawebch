<?php

class Conexion
{
    public static function conectar()
    {       
        
        $conexion = new mysqli('localhost', 'root', '', 'fiscaliach');
        $conexion->set_charset('utf8');
        return $conexion;
    }
}
