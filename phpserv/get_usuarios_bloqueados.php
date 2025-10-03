<?php
/**
 * get_usuarios_bloqueados.php
 * Obtiene la lista de usuarios bloqueados con paginación y filtros
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
    
    // Parámetros de paginación
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $items_per_page = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 10;
    $offset = ($page - 1) * $items_per_page;
    
    // Construir consulta base
    $sql_base = "FROM usuarios WHERE bloqueado = 1";
    $params = array();
    $types = "";
    
    // Aplicar filtros si existen
    if (isset($_GET['user_name']) && !empty($_GET['user_name'])) {
        $sql_base .= " AND (usuario LIKE ? OR Nombre LIKE ? OR Apellido LIKE ?)"; 
        $search_term = "%" . $_GET['user_name'] . "%";
        $params[] = $search_term;
        $params[] = $search_term;
        $params[] = $search_term;
        $types .= "sss";
    }
    
    if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
        $sql_base .= " AND fecha_bloqueo >= ?";
        $params[] = $_GET['date_from'] . " 00:00:00";
        $types .= "s";
    }
    
    if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
        $sql_base .= " AND fecha_bloqueo <= ?";
        $params[] = $_GET['date_to'] . " 23:59:59";
        $types .= "s";
    }
    
    // Consulta para contar el total de registros
    $sql_count = "SELECT COUNT(*) as total " . $sql_base;
    
    // Preparar y ejecutar la consulta de conteo
    $stmt_count = $conn->prepare($sql_count);
    
    // Vincular parámetros si existen
    if (!empty($params)) {
        $stmt_count->bind_param($types, ...$params);
    }
    
    $stmt_count->execute();
    $result_count = $stmt_count->get_result();
    $row_count = $result_count->fetch_assoc();
    $total_records = $row_count['total'];
    
    // Calcular total de páginas
    $total_pages = ceil($total_records / $items_per_page);
    
    // Consulta para obtener los registros paginados
    $sql = "SELECT idusuarios, usuario, Nombre, Apellido, intentos_fallidos, fecha_bloqueo " . $sql_base . " ORDER BY fecha_bloqueo DESC LIMIT ?, ?";
    
    // Añadir parámetros de paginación
    $params[] = $offset;
    $params[] = $items_per_page;
    $types .= "ii";
    
    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Obtener los registros
    $registros = array();
    while ($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
    
    // Preparar respuesta
    $response = array(
        'status' => 'success',
        'message' => 'Usuarios bloqueados obtenidos correctamente',
        'data' => array(
            'registros' => $registros,
            'total_records' => $total_records,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'items_per_page' => $items_per_page
        )
    );
    
} catch (Exception $e) {
    // Registrar el error
    error_log("Error en get_usuarios_bloqueados.php: " . $e->getMessage());
    
    // Preparar respuesta de error
    $response = array(
        'status' => 'error',
        'message' => 'Error al obtener usuarios bloqueados: ' . $e->getMessage()
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