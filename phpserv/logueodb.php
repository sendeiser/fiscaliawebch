<?php
require 'connect.php';
session_start();

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$ip = $_SERVER['REMOTE_ADDR'];

// Obtener información del usuario
$query_usuario = "SELECT * FROM usuarios WHERE usuario='$usuario'";
$resultado_usuario = mysqli_query($conexion, $query_usuario);
$datos_usuario = mysqli_fetch_assoc($resultado_usuario);

// Verificar si el usuario existe
if ($resultado_usuario && mysqli_num_rows($resultado_usuario) > 0) {
    // Verificar si la cuenta está bloqueada
    if ($datos_usuario['bloqueado'] == 1) {
        // Registrar intento en historial
        $id_usuario = $datos_usuario['idusuarios'];
        $query_historial = "INSERT INTO historial_accesos (id_usuario, fecha_hora, ip, exitoso, detalles) 
                           VALUES ($id_usuario, NOW(), '$ip', 0, 'Intento de acceso a cuenta bloqueada')";
        mysqli_query($conexion, $query_historial);
        
        echo json_encode('usuario_bloqueado');
        exit;
    }
}



//CONSULTA A LA BASE DE DATOS
// Inicializar contador de intentos si no existe
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

$accion_nm = "SELECT * FROM usuarios WHERE usuario='$usuario'";
$consulta_nm = mysqli_query($conexion, $accion_nm);
$ussypass = mysqli_num_rows($consulta_nm);


if ($ussypass == 1) {
    // Obtener datos del usuario
    $datos_usuario = mysqli_fetch_assoc($consulta_nm);
    $id_usuario = $datos_usuario['idusuarios'];
    $rol_usuario = $datos_usuario['rol'];
    
    $accion_nm2 = "SELECT * FROM usuarios WHERE usuario='$usuario' and contrasena='$contrasena'";
    $consulta_nm2 = mysqli_query($conexion, $accion_nm2);
    $pssresp = mysqli_num_rows($consulta_nm2);
    
    if ($pssresp == 1) {
        // Inicio de sesión exitoso
        echo json_encode('conexion exitosa');
        
        // Restablecer contador de intentos fallidos
        $reset_intentos = "UPDATE usuarios SET intentos_fallidos = 0 WHERE idusuarios = $id_usuario";
        mysqli_query($conexion, $reset_intentos);
        
        // Guardar información de sesión
        $_SESSION['nombre_usuario'] = $usuario;
        $_SESSION['id_usuario'] = $id_usuario;
        $_SESSION['rol'] = trim($rol_usuario); // Asegurar que no haya espacios
        
        // Registrar el rol en el log para depuración
        error_log("Usuario: $usuario - Rol asignado: " . $_SESSION['rol']);
        
        // Registrar inicio de sesión exitoso
        $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente)
                   VALUES ('Ninguna', 'Inicio de sesion', '$fecha', '$hora', '$usuario', NULL)";
        $conexion->query($sqlreg);
        
        // Registrar en historial de accesos
        $query_historial = "INSERT INTO historial_accesos (id_usuario, fecha_hora, ip, exitoso, detalles) 
                           VALUES ($id_usuario, NOW(), '$ip', 1, 'Inicio de sesión exitoso')";
        mysqli_query($conexion, $query_historial);
    } else {
        // Incrementar contador de intentos fallidos en la base de datos
        $intentos_fallidos = $datos_usuario['intentos_fallidos'] + 1;
        $update_intentos = "UPDATE usuarios SET intentos_fallidos = $intentos_fallidos WHERE idusuarios = $id_usuario";
        mysqli_query($conexion, $update_intentos);
        
        // Registrar intento fallido en historial
        $query_historial = "INSERT INTO historial_accesos (id_usuario, fecha_hora, ip, exitoso, detalles) 
                           VALUES ($id_usuario, NOW(), '$ip', 0, 'Contraseña incorrecta')";
        mysqli_query($conexion, $query_historial);
        
        // Verificar si se alcanzó el límite de intentos
        if ($intentos_fallidos >= 5) {
            // Bloquear la cuenta
            $bloquear_cuenta = "UPDATE usuarios SET bloqueado = 1, fecha_bloqueo = NOW() WHERE idusuarios = $id_usuario";
            mysqli_query($conexion, $bloquear_cuenta);
            
            // Registrar bloqueo en auditoría
            $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente, detalles)
                       VALUES ('usuarios', 'Bloqueo de cuenta', '$fecha', '$hora', '$usuario', NULL, 'Cuenta bloqueada por exceder límite de intentos')";
            $conexion->query($sqlreg);
            
            echo json_encode('usuario_bloqueado');
        } else {
            echo json_encode('contrasena incorrecta');
        }
    }
} else {
    // Usuario no encontrado
    // Registrar intento fallido en auditoría
    $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente, detalles)
               VALUES ('usuarios', 'Intento fallido', '$fecha', '$hora', '$usuario', NULL, 'Usuario no encontrado')";
    $conexion->query($sqlreg);
    
    // Incrementar contador de intentos de sesión
    $_SESSION['login_attempts']++;
    
    // Verificar si se alcanzó el límite de intentos de sesión
    if ($_SESSION['login_attempts'] >= 5) {
        // Registrar bloqueo por IP en auditoría
        $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente, detalles)
                   VALUES ('sistema', 'Bloqueo temporal', '$fecha', '$hora', 'sistema', NULL, 'Bloqueo temporal por múltiples intentos fallidos desde IP: $ip')";
        $conexion->query($sqlreg);
        
        echo json_encode('usuario_bloqueado');
    } else {
        echo json_encode('usuario incorrecto');
    }
}

if ($conexion->errno) die($conexion->error);

$conexion->close();
