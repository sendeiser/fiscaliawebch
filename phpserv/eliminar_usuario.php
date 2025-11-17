<?php
// eliminar_usuario.php - Elimina un usuario (solo administrador)
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/conexion.php';

// Verificar permisos de administrador
$rolSesion = isset($_SESSION['rol']) ? strtolower(trim($_SESSION['rol'])) : null;
$tipoSesion = isset($_SESSION['tipo']) ? strtolower(trim($_SESSION['tipo'])) : null;
if ($rolSesion !== 'administrador' && $tipoSesion !== 'admin') {
    http_response_code(403);
    echo json_encode(['status'=>'error','message'=>'Acceso denegado. Se requiere rol de administrador.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status'=>'error','message'=>'Método no permitido']);
    exit;
}

$id = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : 0;
if ($id <= 0) { http_response_code(400); echo json_encode(['status'=>'error','message'=>'ID inválido']); exit; }

try {
    $db = Conexion::conectar();

    // No permitir borrar a uno mismo
    $idSesion = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : 0;
    if ($idSesion === $id) { http_response_code(403); echo json_encode(['status'=>'error','message'=>'No puede eliminar su propio usuario']); exit; }

    // Eliminar usuario
    $stmt = $db->prepare('DELETE FROM usuarios WHERE idusuarios = ?');
    $stmt->bind_param('i', $id);
    if (!$stmt->execute()) { http_response_code(500); echo json_encode(['status'=>'error','message'=>'Error al eliminar: '.$stmt->error]); $stmt->close(); exit; }
    $affected = $stmt->affected_rows; $stmt->close();
    if ($affected === 0) { http_response_code(404); echo json_encode(['status'=>'error','message'=>'Usuario no encontrado']); exit; }

    // Auditoría
    $admin = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'admin';
    $fecha = date('Y-m-d'); $hora = date('H:i:s');
    $stmt2 = $db->prepare('INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, detalles) VALUES ("usuarios", "Eliminación", ?, ?, ?, ?)');
    $det = 'Eliminación usuario ID: '.$id; $stmt2->bind_param('ssss', $fecha, $hora, $admin, $det); $stmt2->execute(); $stmt2->close();

    http_response_code(200);
    echo json_encode(['status'=>'success','message'=>'Usuario eliminado']);
    $db->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>'Error del servidor']);
}
?>