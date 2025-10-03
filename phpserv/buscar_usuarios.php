<?php
/**
 * buscar_usuarios.php
 * Busca usuarios según un término de búsqueda
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

// Verificar que se recibió el término de búsqueda
if (!isset($_GET['termino']) || empty($_GET['termino'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Término de búsqueda no proporcionado'
    ]);
    exit;
}

// Incluir archivo de conexión a la base de datos
require_once '../connect.php';

// Obtener el término de búsqueda
$termino = '%' . $mysqli->real_escape_string($_GET['termino']) . '%';

// Preparar respuesta
$response = [
    'status' => 'success',
    'data' => []
];

try {
    // Buscar usuarios que coincidan con el término en varios campos
    $query = "SELECT idusuarios, usuario, Nombre, Apellido, rol, 
              intentos_fallidos, bloqueado, fecha_bloqueo 
              FROM usuarios 
              WHERE usuario LIKE ? OR Nombre LIKE ? OR Apellido LIKE ? OR Correo LIKE ? 
              ORDER BY bloqueado DESC, Apellido ASC, Nombre ASC";
    
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssss', $termino, $termino, $termino, $termino);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result) {
        // Obtener todos los usuarios que coinciden
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
        'message' => 'Error al buscar usuarios: ' . $e->getMessage()
    ];
}

// Devolver respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);