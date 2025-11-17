<?php
require 'connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
  exit;
}

$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$apellido = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
$celular = isset($_POST['celular']) ? trim($_POST['celular']) : '';
$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$contrasena = isset($_POST['contrasena']) ? trim($_POST['contrasena']) : '';

if ($correo === '' || $usuario === '' || $contrasena === '' || $nombre === '' || $apellido === '') {
  http_response_code(400);
  echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
  exit;
}

try {
  $stmtPw = $conexion->prepare('SELECT id FROM pwrandom WHERE password_plain = ? LIMIT 1');
  $stmtPw->bind_param('s', $contrasena);
  $stmtPw->execute();
  $stmtPw->store_result();
  if ($stmtPw->num_rows < 1) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Contraseña de registro no autorizada']);
    $stmtPw->close();
    $conexion->close();
    exit;
  }
  $stmtPw->close();

  $stmt = $conexion->prepare('SELECT idusuarios FROM usuarios WHERE Correo = ?');
  $stmt->bind_param('s', $correo);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    http_response_code(409);
    error_log('Intento de registro duplicado para correo: ' . $correo . ' IP: ' . $_SERVER['REMOTE_ADDR']);
    echo json_encode(['status' => 'error', 'message' => 'Usuario ya registrado']);
    $stmt->close();
    $conexion->close();
    exit;
  }
  $stmt->close();

  $stmt2 = $conexion->prepare('SELECT idusuarios FROM usuarios WHERE Usuario = ?');
  $stmt2->bind_param('s', $usuario);
  $stmt2->execute();
  $stmt2->store_result();
  if ($stmt2->num_rows > 0) {
    http_response_code(409);
    error_log('Intento de registro duplicado para usuario: ' . $usuario . ' IP: ' . $_SERVER['REMOTE_ADDR']);
    echo json_encode(['status' => 'error', 'message' => 'Nombre de usuario ya registrado']);
    $stmt2->close();
    $conexion->close();
    exit;
  }
  $stmt2->close();

  $ins = $conexion->prepare('INSERT INTO usuarios (Nombre, Apellido, Celular, Correo, Usuario, Contrasena) VALUES (?,?,?,?,?,?)');
  $ins->bind_param('ssssss', $nombre, $apellido, $celular, $correo, $usuario, $contrasena);
  if ($ins->execute()) {
    if (isset($_POST['do_redirect']) && $_POST['do_redirect'] === '1' && empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
      header('Location: /Login.html', true, 302);
      exit;
    }
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Registro exitoso', 'redirect' => 'Login.html']);
  } else {
    http_response_code(500);
    error_log('Error al insertar usuario: ' . $conexion->error);
    echo json_encode(['status' => 'error', 'message' => 'Error del servidor']);
  }
  $ins->close();
} catch (Exception $e) {
  http_response_code(500);
  error_log('Excepción en registro: ' . $e->getMessage());
  echo json_encode(['status' => 'error', 'message' => 'Error del servidor']);
}

$conexion->close();
?>