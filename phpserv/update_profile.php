<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/connect.php';

$response = ['status' => 'error', 'message' => 'No autorizado'];

try {
    // Validar sesión
    $id = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : 0;
    if ($id <= 0) {
        echo json_encode($response);
        exit;
    }

    // Detectar columnas opcionales
    $hasFoto = false;
    if ($res = $conexion->query("SHOW COLUMNS FROM usuarios LIKE 'foto'")) {
        $hasFoto = ($res->num_rows > 0);
        $res->free();
    }

    // Recibir datos
    $perfilUsuario = isset($_POST['perfilUsuario']) ? trim($_POST['perfilUsuario']) : null; // read-only en UI
    $perfilNombre = isset($_POST['perfilNombre']) ? trim($_POST['perfilNombre']) : null;
    $perfilApellido = isset($_POST['perfilApellido']) ? trim($_POST['perfilApellido']) : null;
    $perfilCorreo = isset($_POST['perfilCorreo']) ? trim($_POST['perfilCorreo']) : null;
    $perfilCelular = isset($_POST['perfilCelular']) ? trim($_POST['perfilCelular']) : null;
    $perfilContrasena = isset($_POST['perfilContrasena']) ? $_POST['perfilContrasena'] : null;
    $perfilContrasenaConfirm = isset($_POST['perfilContrasenaConfirm']) ? $_POST['perfilContrasenaConfirm'] : null;

    if (($perfilContrasena || $perfilContrasenaConfirm) && $perfilContrasena !== $perfilContrasenaConfirm) {
        echo json_encode(['status' => 'error', 'message' => 'Las contraseñas no coinciden']);
        exit;
    }

    // Manejo de foto de perfil
    $fotoPath = null;
    if (isset($_FILES['perfilFoto']) && $_FILES['perfilFoto']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = realpath(__DIR__ . '/../images');
        if ($uploadDir === false) $uploadDir = __DIR__ . '/../images';
        $profilesDir = $uploadDir . DIRECTORY_SEPARATOR . 'profiles';
        if (!is_dir($profilesDir)) {
            @mkdir($profilesDir, 0777, true);
        }
        $ext = pathinfo($_FILES['perfilFoto']['name'], PATHINFO_EXTENSION);
        $safeExt = preg_replace('/[^a-zA-Z0-9]/', '', $ext);
        if (!$safeExt) { $safeExt = 'jpg'; }
        $filename = 'user_' . $id . '_' . date('YmdHis') . '.' . $safeExt;
        $dest = $profilesDir . DIRECTORY_SEPARATOR . $filename;
        if (move_uploaded_file($_FILES['perfilFoto']['tmp_name'], $dest)) {
            // Ruta relativa para servir desde el navegador
            $fotoPath = 'images/profiles/' . $filename;
            // Si la columna 'foto' no existe aún, crearla automáticamente
            if (!$hasFoto) {
                $conexion->query("ALTER TABLE usuarios ADD COLUMN foto VARCHAR(255) NULL");
                $hasFoto = true;
            }
        }
    }

    // Construir UPDATE dinámico
    $fields = [];
    $params = [];
    $types = '';

    if ($perfilNombre !== null) { $fields[] = 'Nombre = ?'; $params[] = $perfilNombre; $types .= 's'; }
    if ($perfilApellido !== null) { $fields[] = 'Apellido = ?'; $params[] = $perfilApellido; $types .= 's'; }
    if ($perfilCorreo !== null) { $fields[] = 'Correo = ?'; $params[] = $perfilCorreo; $types .= 's'; }
    if ($perfilCelular !== null) { $fields[] = 'Celular = ?'; $params[] = $perfilCelular; $types .= 's'; }
    if ($perfilContrasena !== null && $perfilContrasena !== '') { $fields[] = 'contrasena = ?'; $params[] = $perfilContrasena; $types .= 's'; }
    if ($hasFoto && $fotoPath) { $fields[] = 'foto = ?'; $params[] = $fotoPath; $types .= 's'; }

    if (empty($fields)) {
        echo json_encode(['status' => 'error', 'message' => 'No hay cambios para actualizar']);
        exit;
    }

    $sql = 'UPDATE usuarios SET ' . implode(', ', $fields) . ' WHERE idusuarios = ?';
    $types .= 'i';
    $params[] = $id;

    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Error preparando consulta: ' . $conexion->error]);
        exit;
    }

    $stmt->bind_param($types, ...$params);
    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar: ' . $stmt->error]);
        $stmt->close();
        exit;
    }
    $stmt->close();

    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Excepción: ' . $e->getMessage()]);
}