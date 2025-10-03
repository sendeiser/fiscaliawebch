<?php
/**
 * get_auditoria.php - Obtiene registros de auditoría con paginación y filtros
 */

// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de cabeceras
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fiscaliach";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error de conexión: ' . $conn->connect_error
    ]);
    exit;
}

// Establecer charset
$conn->set_charset("utf8");

// Parámetros de paginación
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 15;

// Calcular offset para la consulta SQL
$offset = ($page - 1) * $items_per_page;

// Construir consulta base
$sql_count = "SELECT COUNT(*) as total FROM auditoria";
$sql = "SELECT * FROM auditoria";

// Array para condiciones WHERE
$where_conditions = [];
$params = [];
$types = "";

// Filtros
if (isset($_GET['tabla']) && !empty($_GET['tabla'])) {
    $where_conditions[] = "tabla_afectada LIKE ?";
    $params[] = "%{$_GET['tabla']}%";
    $types .= "s";
}

if (isset($_GET['operacion']) && !empty($_GET['operacion'])) {
    $where_conditions[] = "operacion LIKE ?";
    $params[] = "%{$_GET['operacion']}%";
    $types .= "s";
}

if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
    $where_conditions[] = "fecha >= ?";
    $params[] = $_GET['date_from'];
    $types .= "s";
}

if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
    $where_conditions[] = "fecha <= ?";
    $params[] = $_GET['date_to'];
    $types .= "s";
}

if (isset($_GET['usuario']) && !empty($_GET['usuario'])) {
    $where_conditions[] = "usuario LIKE ?";
    $params[] = "%{$_GET['usuario']}%";
    $types .= "s";
}

if (isset($_GET['expediente']) && !empty($_GET['expediente'])) {
    $where_conditions[] = "num_expediente LIKE ?";
    $params[] = "%{$_GET['expediente']}%";
    $types .= "s";
}

if (isset($_GET['dni']) && !empty($_GET['dni'])) {
    $where_conditions[] = "dni LIKE ?";
    $params[] = "%{$_GET['dni']}%";
    $types .= "s";
}

// Añadir condiciones WHERE si existen
if (!empty($where_conditions)) {
    $sql_count .= " WHERE " . implode(" AND ", $where_conditions);
    $sql .= " WHERE " . implode(" AND ", $where_conditions);
}

// Ordenar por fecha y hora descendente (más reciente primero)
$sql .= " ORDER BY fecha DESC, hora DESC";

// Añadir límite para paginación
$sql .= " LIMIT ? OFFSET ?";
$params[] = $items_per_page;
$types .= "i";
$params[] = $offset;
$types .= "i";

// Preparar y ejecutar consulta para contar registros
$stmt_count = $conn->prepare($sql_count);

// Clonar los parámetros para la consulta de conteo (sin los parámetros de paginación)
$count_params = [];
$count_types = "";

// Copiar solo los parámetros de filtrado (no los de paginación)
for ($i = 0; $i < count($params) - 2; $i++) {
    $count_params[] = $params[$i];
    $count_types .= substr($types, $i, 1);
}

if (!empty($count_params)) {
    $stmt_count->bind_param($count_types, ...$count_params);
}

$stmt_count->execute();
$result_count = $stmt_count->get_result();
$row_count = $result_count->fetch_assoc();
$total_records = $row_count['total'];
$total_pages = ceil($total_records / $items_per_page);

// Preparar y ejecutar consulta para obtener registros
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Preparar respuesta
$registros = [];

while ($row = $result->fetch_assoc()) {
    $registros[] = $row;
}

// Devolver respuesta JSON
echo json_encode([
    'status' => 'success',
    'data' => [
        'registros' => $registros,
        'total_pages' => $total_pages,
        'current_page' => $page,
        'items_per_page' => $items_per_page,
        'total_records' => $total_records
    ]
]);

// Cerrar conexiones
$stmt->close();
$stmt_count->close();
$conn->close();