<?php
class Conexion{
    public static function conectar(){
        $conexion = new mysqli('localhost','root','martin/123','Fiscalia');
        $conexion->set_charset('utf8');
        return $conexion;
    }
}