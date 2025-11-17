<?php
session_start();
header('Content-Type: application/json');
require 'connect.php';

$isAuto = isset($_POST['reason']) && $_POST['reason'] === 'auto_inactivity';
$usuario = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'sistema';
$operacion = $isAuto ? 'Cierre de sesion por inactividad' : 'Cierre de sesion';

// Registrar cierre de sesión en auditoría (una sola entrada)
$sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente) VALUES ('usuarios', '$operacion', '$fecha', '$hora', '$usuario', NULL)";
$conexion->query($sqlreg);

$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}
session_destroy();

echo json_encode(['status' => 'success']);