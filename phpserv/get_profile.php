<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/connect.php';

$response = ['status' => 'error', 'message' => 'No autorizado'];

try {
    // Identificar usuario en sesión
    $id = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : 0;
    $usuarioSesion = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : null;

    if ($id <= 0 && !$usuarioSesion) {
        echo json_encode($response);
        exit;
    }

    // Detectar si existe la columna foto
    $hasFoto = false;
    if ($res = $conexion->query("SHOW COLUMNS FROM usuarios LIKE 'foto'")) {
        $hasFoto = ($res->num_rows > 0);
        $res->free();
    }

    // Construir SELECT según disponibilidad de columna
    $select = "SELECT idusuarios, usuario, Nombre, Apellido, Correo, Celular, rol" . ($hasFoto ? ", foto" : "") . " FROM usuarios WHERE ";
    $where = '';
    $stmt = null;

    if ($id > 0) {
        $where = "idusuarios = ?";
        $stmt = $conexion->prepare($select . $where);
        $stmt->bind_param('i', $id);
    } else {
        $where = "usuario = ?";
        $stmt = $conexion->prepare($select . $where);
        $stmt->bind_param('s', $usuarioSesion);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        $response = ['status' => 'success', 'user' => $row];
    } else {
        $response = ['status' => 'error', 'message' => 'Usuario no encontrado'];
    }
    $result && $result->free();
    $stmt && $stmt->close();
} catch (Exception $e) {
    $response = ['status' => 'error', 'message' => 'Error al obtener perfil: ' . $e->getMessage()];
}

echo json_encode($response);