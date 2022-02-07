<?php
class Conexion{
    public static function conectar(){
        $conexion = new mysqli('45.236.131.227','root','martin/123','Fiscalia');
        $conexion->set_charset('utf8');
        return $conexion;
    }
}