<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['rol'])) {
    // Asegurar que el rol sea una cadena simple
    $rol = trim($_SESSION['rol']);
    echo json_encode($rol);
} else {
    echo json_encode('usuario'); // Valor por defecto
}
?>