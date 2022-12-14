<?php
class Conexion{
    public static function conectar(){
        $conexion = new mysqli('localhost','c2191769_fisca','zusuMI83fu','c2191769_fisca');
        $conexion->set_charset('utf8');
        return $conexion;
    }
}