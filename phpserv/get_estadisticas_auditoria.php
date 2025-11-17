<?php
/**
 * get_estadisticas_auditoria.php - Obtiene estadísticas de la tabla de auditoría
 */

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

// Obtener estadísticas

// 1. Total de operaciones
$sql_total = "SELECT COUNT(*) as total FROM auditoria";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_operaciones = $row_total['total'];

// 2. Operaciones por tipo
$sql_inserciones = "SELECT COUNT(*) as total FROM auditoria WHERE operacion = 'INSERT'";
$result_inserciones = $conn->query($sql_inserciones);
$row_inserciones = $result_inserciones->fetch_assoc();
$total_inserciones = $row_inserciones['total'];

$sql_informes = "SELECT COUNT(*) as total FROM auditoria WHERE operacion = 'Nuevo Registro de expediente'";
$result_informes = $conn->query($sql_informes);
$row_informes = $result_informes->fetch_assoc();
$total_informes = $row_informes['total'];

$sql_actualizaciones = "SELECT COUNT(*) as total FROM auditoria WHERE operacion IN ('Se edito un expediente','Se edito una comisaria','Se edito una persona')";
$result_actualizaciones = $conn->query($sql_actualizaciones);
$row_actualizaciones = $result_actualizaciones->fetch_assoc();
$total_actualizaciones = $row_actualizaciones['total'];

$sql_eliminaciones = "SELECT COUNT(*) as total FROM auditoria WHERE operacion IN ('Se elimino una persona','Se elimino un expediente','Se elimino una comisaria')";
$result_eliminaciones = $conn->query($sql_eliminaciones);
$row_eliminaciones = $result_eliminaciones->fetch_assoc();
$total_eliminaciones = $row_eliminaciones['total'];

// 3. Tablas más afectadas (top 5)
$sql_tablas = "SELECT tabla_afectada, COUNT(*) as total FROM auditoria GROUP BY tabla_afectada ORDER BY total DESC LIMIT 5";
$result_tablas = $conn->query($sql_tablas);
$tablas_afectadas = [];

while ($row = $result_tablas->fetch_assoc()) {
    $tablas_afectadas[] = [
        'tabla' => $row['tabla_afectada'],
        'total' => $row['total']
    ];
}

// Devolver respuesta JSON
echo json_encode([
    'status' => 'success',
    'data' => [
        'total_operaciones' => $total_operaciones,
        'total_inserciones' => $total_inserciones,
        'total_informes' => $total_informes,
        'total_actualizaciones' => $total_actualizaciones,
        'total_eliminaciones' => $total_eliminaciones,
        'tablas_afectadas' => $tablas_afectadas
    ]
]);

// Cerrar conexión
$conn->close();