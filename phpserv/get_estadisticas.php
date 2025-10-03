<?php
/**
 * get_estadisticas.php
 * Obtiene estadísticas generales para el panel de administración
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
require_once '../connect.php';

// Preparar respuesta
$response = [
    'status' => 'success',
    'data' => [
        'cuentas_bloqueadas' => 0,
        'intentos_fallidos_hoy' => 0,
        'usuarios_activos' => 0
    ]
];

try {
    // Obtener número de cuentas bloqueadas
    $query = "SELECT COUNT(*) as total FROM usuarios WHERE bloqueado = 1";
    $result = $mysqli->query($query);
    
    if ($result) {
        $row = $result->fetch_assoc();
        $response['data']['cuentas_bloqueadas'] = (int)$row['total'];
    }
    
    // Obtener número de intentos fallidos hoy
    $query = "SELECT COUNT(*) as total FROM historial_accesos 
              WHERE fecha >= CURDATE() AND exito = 0";
    $result = $mysqli->query($query);
    
    if ($result) {
        $row = $result->fetch_assoc();
        $response['data']['intentos_fallidos_hoy'] = (int)$row['total'];
    }
    
    // Obtener número de usuarios activos (no bloqueados)
    $query = "SELECT COUNT(*) as total FROM usuarios WHERE bloqueado = 0 OR bloqueado IS NULL";
    $result = $mysqli->query($query);
    
    if ($result) {
        $row = $result->fetch_assoc();
        $response['data']['usuarios_activos'] = (int)$row['total'];
    }
    
} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
    ];
}

// Devolver respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);