<?php
/**
 * get_historial.php
 * Obtiene el historial de accesos al sistema con paginación y filtros
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
    'message' => 'Error al obtener historial',
    'data' => null
];

try {
    // Crear conexión a la base de datos
    $conn = Conexion::conectar();
    
    // Parámetros de paginación
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $items_per_page = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 15;
    
    // Validar parámetros
    if ($page < 1) $page = 1;
    if ($items_per_page < 1 || $items_per_page > 100) $items_per_page = 15;
    
    // Calcular offset
    $offset = ($page - 1) * $items_per_page;
    
    // Construir consulta base
    $sql_base = "FROM historial_accesos h LEFT JOIN usuarios u ON h.usuario_id = u.id";
    $where_clauses = [];
    $params = [];
    
    // Aplicar filtros si existen
    // 1. Filtro por fecha desde
    if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
        $where_clauses[] = "h.fecha >= :date_from";
        $params[':date_from'] = $_GET['date_from'] . ' 00:00:00';
    }
    
    // 2. Filtro por fecha hasta
    if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
        $where_clauses[] = "h.fecha <= :date_to";
        $params[':date_to'] = $_GET['date_to'] . ' 23:59:59';
    }
    
    // 3. Filtro por estado (exitoso/fallido)
    if (isset($_GET['status']) && $_GET['status'] !== '') {
        $where_clauses[] = "h.exito = :status";
        $params[':status'] = ($_GET['status'] === 'success') ? 1 : 0;
    }
    
    // 4. Filtro por usuario
    if (isset($_GET['user']) && !empty($_GET['user'])) {
        $where_clauses[] = "(u.usuario LIKE :user OR u.nombre LIKE :user OR u.apellido LIKE :user)";
        $params[':user'] = '%' . $_GET['user'] . '%';
    }
    
    // Construir cláusula WHERE completa
    $where_sql = '';
    if (!empty($where_clauses)) {
        $where_sql = "WHERE " . implode(" AND ", $where_clauses);
    }
    
    // Consulta para contar total de registros
    $count_sql = "SELECT COUNT(*) as total $sql_base $where_sql";
    $stmt = $conn->prepare($count_sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $total_records = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Calcular total de páginas
    $total_pages = ceil($total_records / $items_per_page);
    
    // Consulta para obtener registros paginados
    $sql = "SELECT h.id, h.usuario_id, u.usuario, h.fecha, h.ip, h.exito, h.detalles 
           $sql_base $where_sql 
           ORDER BY h.fecha DESC 
           LIMIT :offset, :limit";
    
    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();
    
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Preparar respuesta exitosa
    $response = [
        'status' => 'success',
        'message' => 'Historial obtenido correctamente',
        'data' => [
            'registros' => $registros,
            'total_records' => $total_records,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'items_per_page' => $items_per_page
        ]
    ];
    
} catch (PDOException $e) {
    // Registrar error en log del servidor
    error_log("Error en get_historial.php: " . $e->getMessage());
    
    // Actualizar mensaje de error
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
} finally {
    // Cerrar conexión
    $conn = null;
}

// Devolver respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);