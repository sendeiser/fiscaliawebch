<?php
/**
 * exportar_usuarios_csv.php
 * Exporta la lista de usuarios a formato CSV
 */

// Iniciar sesión
session_start();

// Verificar permisos de administrador de forma consistente
$rolSesion = isset($_SESSION['rol']) ? strtolower(trim($_SESSION['rol'])) : null;
$tipoSesion = isset($_SESSION['tipo']) ? strtolower(trim($_SESSION['tipo'])) : null;
if ($rolSesion !== 'administrador' && $tipoSesion !== 'admin') {
    header('Content-Type: text/plain');
    echo 'Acceso denegado. Se requiere rol de administrador.';
    exit;
}

// Incluir archivo de conexión a la base de datos
require_once 'connect.php';

try {
    // Consultar todos los usuarios con sus datos relevantes
    $query = "SELECT idusuarios, usuario, Nombre, Apellido, Correo, Celular, 
              rol, intentos_fallidos, bloqueado, fecha_bloqueo 
              FROM usuarios 
              ORDER BY bloqueado DESC, Apellido ASC, Nombre ASC";
    
    $result = $conexion->query($query);
    
    if (!$result) {
        throw new Exception("Error en la consulta: " . $conexion->error);
    }
    
    // Configurar cabeceras para descarga de archivo CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=usuarios_' . date('Y-m-d') . '.csv');
    
    // Crear un puntero de archivo en la salida
    $output = fopen('php://output', 'w');
    
    // Añadir BOM para UTF-8
    fprintf($output, "\xEF\xBB\xBF");
    
    // Escribir encabezados del CSV
    fputcsv($output, [
        'ID', 'Usuario', 'Nombre', 'Apellido', 'Correo', 'Celular',
        'Rol', 'Intentos Fallidos', 'Estado', 'Fecha Bloqueo'
    ]);
    
    // Escribir datos de usuarios
    while ($row = $result->fetch_assoc()) {
        // Formatear estado
        $estado = ($row['bloqueado'] == 1) ? 'Bloqueado' : 'Activo';
        
        // Escribir fila en el CSV
        fputcsv($output, [
            $row['idusuarios'],
            $row['usuario'],
            $row['Nombre'],
            $row['Apellido'],
            $row['Correo'],
            $row['Celular'],
            $row['rol'] ?: 'usuario',
            $row['intentos_fallidos'],
            $estado,
            $row['fecha_bloqueo']
        ]);
    }
    
    // Cerrar el resultado
    $result->free();
    
    // Registrar acción en auditoría (esquema actual)
    $usuarioAud = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'sistema';
    $detallesAud = 'Exportación de usuarios a CSV';
    $stmtAud = $conexion->prepare("INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, detalles) VALUES ('usuarios','EXPORT',DATE(NOW()),TIME(NOW()),?,?)");
    $stmtAud->bind_param('ss', $usuarioAud, $detallesAud);
    $stmtAud->execute();
    $stmtAud->close();
    
} catch (Exception $e) {
    // En caso de error, devolver mensaje de texto plano
    header('Content-Type: text/plain');
    echo 'Error al exportar usuarios: ' . $e->getMessage();
}
