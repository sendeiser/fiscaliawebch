<?php
/**
 * exportar_historial_csv.php
 * Exporta el historial de accesos a un archivo CSV
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

try {
    // Crear conexión a la base de datos
    $conn = Conexion::conectar();
    
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
    
    // Consulta para obtener todos los registros (sin paginación)
    $sql = "SELECT h.id, u.usuario, h.fecha, h.ip, h.exito, h.detalles 
           $sql_base $where_sql 
           ORDER BY h.fecha DESC";
    
    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Registrar la acción en la tabla de auditoría
    $sql_audit = "INSERT INTO auditoria (usuario_id, accion, detalles, fecha) 
                 VALUES (:usuario_id, 'exportar_csv', 'Exportación de historial de accesos a CSV', NOW())";
    $stmt_audit = $conn->prepare($sql_audit);
    $stmt_audit->bindValue(':usuario_id', $_SESSION['usuario_id'], PDO::PARAM_INT);
    $stmt_audit->execute();
    
    // Configurar cabeceras para descarga de CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=historial_accesos_' . date('Y-m-d') . '.csv');
    
    // Crear archivo CSV
    $output = fopen('php://output', 'w');
    
    // Establecer el separador de campo y el encapsulador
    $delimiter = ';';
    $enclosure = '"';
    
    // Escribir BOM para UTF-8
    fprintf($output, "\xEF\xBB\xBF");
    
    // Escribir encabezados
    fputcsv($output, ['ID', 'Usuario', 'Fecha', 'Dirección IP', 'Estado', 'Detalles'], $delimiter, $enclosure);
    
    // Escribir datos
    foreach ($registros as $registro) {
        $estado = ($registro['exito'] == 1) ? 'Exitoso' : 'Fallido';
        fputcsv($output, [
            $registro['id'],
            $registro['usuario'] ?: 'N/A',
            $registro['fecha'],
            $registro['ip'],
            $estado,
            $registro['detalles'] ?: '-'
        ], $delimiter, $enclosure);
    }
    
    // Cerrar archivo
    fclose($output);
    
} catch (PDOException $e) {
    // Registrar error en log del servidor
    error_log("Error en exportar_historial_csv.php: " . $e->getMessage());
    
    // Devolver mensaje de error
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
} finally {
    // Cerrar conexión
    $conn = null;
}

// No es necesario devolver nada más, el archivo CSV ya se ha enviado
exit;