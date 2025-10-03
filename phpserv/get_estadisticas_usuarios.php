<?php
/**
 * get_estadisticas_usuarios.php
 * Obtiene estadísticas de usuarios para el panel de control
 */

// Iniciar sesión
session_start();

// Incluir archivo de conexión a la base de datos
require_once 'conexion.php';

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

try {
    // Conectar a la base de datos
    $conn = Conexion::conectar();
    
    // Consulta para obtener el número de usuarios activos (no bloqueados)
    $sql_activos = "SELECT COUNT(*) as total FROM usuarios WHERE bloqueado = 0";
    $result_activos = $conn->query($sql_activos);
    $row_activos = $result_activos->fetch_assoc();
    $usuarios_activos = $row_activos['total'];
    
    // Consulta para obtener el número de usuarios bloqueados
    $sql_bloqueados = "SELECT COUNT(*) as total FROM usuarios WHERE bloqueado = 1";
    $result_bloqueados = $conn->query($sql_bloqueados);
    $row_bloqueados = $result_bloqueados->fetch_assoc();
    $usuarios_bloqueados = $row_bloqueados['total'];
    
    // Preparar respuesta
    $response = array(
        'status' => 'success',
        'message' => 'Estadísticas obtenidas correctamente',
        'data' => array(
            'usuarios_activos' => $usuarios_activos,
            'usuarios_bloqueados' => $usuarios_bloqueados
        )
    );
    
} catch (Exception $e) {
    // Registrar el error
    error_log("Error en get_estadisticas_usuarios.php: " . $e->getMessage());
    
    // Preparar respuesta de error
    $response = array(
        'status' => 'error',
        'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
    );
} finally {
    // Cerrar conexión
    if (isset($conn)) {
        $conn->close();
    }
    
    // Enviar respuesta
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>