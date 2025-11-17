<?php
// actualizar_usuario.php - Actualiza datos de un usuario (solo administrador)
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

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : null;
$apellido = isset($_POST['apellido']) ? trim($_POST['apellido']) : null;
$rol = isset($_POST['rol']) ? trim($_POST['rol']) : null;
$correo = isset($_POST['correo']) ? trim($_POST['correo']) : null;
$contrasena = isset($_POST['contrasena']) ? trim($_POST['contrasena']) : null;

if ($id <= 0) { echo json_encode(['status'=>'error','message'=>'ID inválido']); exit; }

try {
    $db = Conexion::conectar();

    $fields = [];
    $params = [];
    $types = '';

    if ($nombre !== null) { $fields[] = 'Nombre = ?'; $params[] = $nombre; $types .= 's'; }
    if ($apellido !== null) { $fields[] = 'Apellido = ?'; $params[] = $apellido; $types .= 's'; }
    if ($rol !== null) { $fields[] = 'rol = ?'; $params[] = $rol; $types .= 's'; }
    if ($correo !== null) { $fields[] = 'Correo = ?'; $params[] = $correo; $types .= 's'; }
    if ($contrasena !== null && $contrasena !== '') { $fields[] = 'contrasena = ?'; $params[] = $contrasena; $types .= 's'; }

    if (empty($fields)) { http_response_code(400); echo json_encode(['status'=>'error','message'=>'Sin cambios']); exit; }

    $sql = 'UPDATE usuarios SET ' . implode(', ', $fields) . ' WHERE idusuarios = ?';
    $types .= 'i'; $params[] = $id;

    $stmt = $db->prepare($sql);
    if (!$stmt) { http_response_code(500); echo json_encode(['status'=>'error','message'=>'Error preparando consulta']); exit; }
    $stmt->bind_param($types, ...$params);
    if (!$stmt->execute()) { http_response_code(500); echo json_encode(['status'=>'error','message'=>'Error al actualizar: '.$stmt->error]); $stmt->close(); exit; }
    $stmt->close();

    // Auditoría
    $admin = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'admin';
    $fecha = date('Y-m-d'); $hora = date('H:i:s');
    $stmt2 = $db->prepare('INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, detalles) VALUES ("usuarios", "Actualización", ?, ?, ?, ?)');
    $det = 'Actualización usuario ID: '.$id; $stmt2->bind_param('ssss', $fecha, $hora, $admin, $det); $stmt2->execute(); $stmt2->close();

    http_response_code(200);
    echo json_encode(['status'=>'success','message'=>'Usuario actualizado']);
    $db->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>'Error del servidor']);
}
?>