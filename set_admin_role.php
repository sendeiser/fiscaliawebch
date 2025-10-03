<?php
session_start();
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fiscaliach";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Usuario al que queremos asignar rol de administrador
$usuario = "sendeiser"; // Cambiar por el usuario que deseas convertir en administrador

// Actualizar el rol del usuario a administrador
$sql = "UPDATE usuarios SET rol = 'administrador' WHERE usuario = '$usuario'";

if ($conn->query($sql) === TRUE) {
    echo "<p>El usuario '$usuario' ahora tiene rol de administrador</p>";
    // Establecer sesión como administrador para pruebas de endpoints
    $_SESSION['rol'] = 'administrador';
    $_SESSION['nombre_usuario'] = $usuario;
    echo "<p>Sesión establecida como administrador para '$usuario'</p>";
} else {
    echo "<p>Error al actualizar el rol: " . $conn->error . "</p>";
}

// Verificar el cambio
$sql = "SELECT usuario, rol FROM usuarios WHERE usuario = '$usuario'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<p>Usuario: " . $row["usuario"] . " - Rol actual: " . $row["rol"] . "</p>";
}

$conn->close();

echo "<p><a href='check_admin_users.php'>Ver todos los usuarios y roles</a></p>";
?>