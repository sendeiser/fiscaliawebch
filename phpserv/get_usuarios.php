<?php
/**
 * get_usuarios.php
 * Obtiene la lista de usuarios para el panel de administración
 */

// Iniciar sesión
session_start();

// Verificar permisos de administrador de forma consistente
$rolSesion = isset($_SESSION['rol']) ? strtolower(trim($_SESSION['rol'])) : null;
$tipoSesion = isset($_SESSION['tipo']) ? strtolower(trim($_SESSION['tipo'])) : null;
if ($rolSesion !== 'administrador' && $tipoSesion !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Acceso denegado. Se requiere rol de administrador.'
    ]);
    exit;
}

// Incluir archivo de conexión a la base de datos
require_once 'conexion.php';

// Preparar respuesta
$response = [
    'status' => 'success',
    'data' => []
];

try {
    // Crear conexión a la base de datos
    $mysqli = Conexion::conectar();
    
    // Consultar todos los usuarios con sus datos relevantes
    $query = "SELECT idusuarios, usuario, Nombre, Apellido, rol, 
              intentos_fallidos, bloqueado, fecha_bloqueo 
              FROM usuarios 
              ORDER BY bloqueado DESC, Apellido ASC, Nombre ASC";
    
    $result = $mysqli->query($query);
    
    if ($result) {
        // Obtener todos los usuarios
        while ($row = $result->fetch_assoc()) {
            // Asegurar que los valores numéricos sean realmente números
            $row['idusuarios'] = (int)$row['idusuarios'];
            $row['intentos_fallidos'] = (int)$row['intentos_fallidos'];
            $row['bloqueado'] = (int)$row['bloqueado'];
            
            // Añadir a la respuesta
            $response['data'][] = $row;
        }
        
        $result->free();
    } else {
        throw new Exception("Error en la consulta: " . $mysqli->error);
    }
    
} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => 'Error al obtener usuarios: ' . $e->getMessage()
    ];
}

// Devolver respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);