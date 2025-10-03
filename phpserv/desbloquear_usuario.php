<?php
/**
 * desbloquear_usuario.php
 * Desbloquea un usuario y reinicia su contador de intentos fallidos
 */

// Iniciar sesión
session_start();

// Verificar permisos de administrador de forma consistente
// Aceptar tanto "rol=administrador" como "tipo=admin" por compatibilidad
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

// Verificar que se recibió el ID de usuario
if (!isset($_POST['id_usuario']) || empty($_POST['id_usuario'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'ID de usuario no proporcionado'
    ]);
    exit;
}

// Incluir archivo de conexión a la base de datos
require_once 'conexion.php';

// Obtener el ID del usuario a desbloquear
$id_usuario = (int)$_POST['id_usuario'];

// Preparar respuesta
$response = [
    'status' => 'success',
    'message' => 'Usuario desbloqueado exitosamente'
];

try {
    // Conectar a la base de datos
    $conn = Conexion::conectar();
    
    // Iniciar transacción
    $conn->begin_transaction();
    
    // Desbloquear al usuario y reiniciar sus intentos fallidos
    $query = "UPDATE usuarios SET bloqueado = 0, intentos_fallidos = 0, fecha_bloqueo = NULL 
              WHERE idusuarios = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_usuario);
    
    if (!$stmt->execute()) {
        throw new Exception("Error al desbloquear usuario: " . $stmt->error);
    }
    
    // Verificar si se actualizó algún registro
    if ($stmt->affected_rows === 0) {
        throw new Exception("No se encontró el usuario con ID: $id_usuario");
    }
    
    // Registrar en la tabla de auditoría
    // Usar el nombre de usuario en sesión establecido al iniciar sesión
    $admin_usuario = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : (isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'sistema');
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Ajustar a esquema de auditoría existente: usar columnas estándar
    $query = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente) 
              VALUES ('usuarios', 'Desbloqueo', ?, ?, ?, NULL)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $fecha, $hora, $admin_usuario);
    
    if (!$stmt->execute()) {
        throw new Exception("Error al registrar en auditoría: " . $stmt->error);
    }
    
    // Confirmar transacción
    $conn->commit();
    
} catch (Exception $e) {
    // Revertir transacción en caso de error
    $conn->rollback();
    
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

// Devolver respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);