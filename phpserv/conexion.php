<?php
/**
 * conexion.php
 * Clase para manejar la conexión a la base de datos
 */

class Conexion {
    /**
     * Establece una conexión a la base de datos
     * @return mysqli Objeto de conexión a la base de datos
     */
    public static function conectar() {
        $mysqli = new mysqli("localhost", "root", "", "fiscaliach");
        $mysqli->set_charset('utf8');
        
        if ($mysqli->connect_error) {
            die("Error de conexión: " . $mysqli->connect_error);
        }
        
        return $mysqli;
    }
}