<?php
// Configuración para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de cabeceras
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Verificar el método de solicitud
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
    exit;
}

// Obtener el ID del registro a eliminar
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "ID no proporcionado"]);
    exit;
}

$id = intval($_GET['id']);

// Conectar a la base de datos
require_once '../bd/conexion.php';
$conexion = Conexion::conectar();

// Preparar la consulta SQL
$sql = "DELETE FROM auditoria WHERE id = :id";

try {
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => "Registro eliminado correctamente"]);
        } else {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "No se encontró el registro"]);
        }
    } else {
        throw new Exception("Error al eliminar el registro");
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conexion = null;
}
?>