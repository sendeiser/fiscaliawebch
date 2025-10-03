<?php
/**
 * get_estadisticas_historial.php
 * Obtiene estadísticas generales para el panel de historial de accesos
 */

// Iniciar sesión
session_start();

// Incluir archivo de conexión a la base de datos
require_once 'conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No autorizado'
    ]);
    exit;
}

// Crear respuesta por defecto
$response = [
    'status' => 'error',
    'message' => 'Error al obtener estadísticas',
    'data' => null
];

try {
    // Crear conexión a la base de datos
    $conn = Conexion::conectar();
    
    // Obtener estadísticas
    $stats = [];
    
    // 1. Accesos exitosos (últimos 30 días)
    $sql = "SELECT COUNT(*) as total FROM historial_accesos WHERE exito = 1 AND fecha >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['accesos_exitosos'] = $result['total'];
    
    // 2. Accesos fallidos (últimos 30 días)
    $sql = "SELECT COUNT(*) as total FROM historial_accesos WHERE exito = 0 AND fecha >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['accesos_fallidos'] = $result['total'];
    
    // 3. Bloqueos (últimos 30 días)
    $sql = "SELECT COUNT(*) as total FROM historial_accesos 
           WHERE exito = 0 AND detalles LIKE '%bloqueado%' AND fecha >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['bloqueos'] = $result['total'];
    
    // Preparar respuesta exitosa
    $response = [
        'status' => 'success',
        'message' => 'Estadísticas obtenidas correctamente',
        'data' => $stats
    ];
    
} catch (PDOException $e) {
    // Registrar error en log del servidor
    error_log("Error en get_estadisticas_historial.php: " . $e->getMessage());
    
    // Actualizar mensaje de error
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
} finally {
    // Cerrar conexión
    $conn = null;
}

// Devolver respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);