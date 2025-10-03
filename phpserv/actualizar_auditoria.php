<?php
// Configuración para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de cabeceras
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Verificar el método de solicitud
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
    exit;
}

// Obtener datos enviados
$data = json_decode(file_get_contents("php://input"), true);

// Verificar que se recibieron datos
if (!$data || !isset($data['id'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Datos incompletos o inválidos"]);
    exit;
}

// Conectar a la base de datos
require_once '../bd/conexion.php';
$conexion = Conexion::conectar();

// Preparar la consulta SQL
$sql = "UPDATE auditoria SET 
        usuario = :usuario,
        tabla_afectada = :tabla_afectada,
        operacion = :operacion,
        num_expediente = :num_expediente,
        dni = :dni,
        detalles = :detalles
        WHERE id = :id";

try {
    $stmt = $conexion->prepare($sql);
    
    // Vincular parámetros
    $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindParam(':usuario', $data['usuario'], PDO::PARAM_STR);
    $stmt->bindParam(':tabla_afectada', $data['tabla_afectada'], PDO::PARAM_STR);
    $stmt->bindParam(':operacion', $data['operacion'], PDO::PARAM_STR);
    $stmt->bindParam(':num_expediente', $data['num_expediente'], PDO::PARAM_STR);
    $stmt->bindParam(':dni', $data['dni'], PDO::PARAM_STR);
    $stmt->bindParam(':detalles', $data['detalles'], PDO::PARAM_STR);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Registro actualizado correctamente"]);
    } else {
        throw new Exception("Error al actualizar el registro");
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conexion = null;
}
?>