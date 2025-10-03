<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fiscaliach";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consultar usuarios administradores
$sql = "SELECT usuario, rol FROM usuarios WHERE rol = 'administrador'";
$result = $conn->query($sql);

echo "<h2>Usuarios con rol de administrador:</h2>";

if ($result->num_rows > 0) {
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>Usuario: " . $row["usuario"] . " - Rol: " . $row["rol"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No hay usuarios con rol de administrador</p>";
}

// Consultar todos los usuarios y sus roles
echo "<h2>Todos los usuarios y sus roles:</h2>";
$sql = "SELECT usuario, rol FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>Usuario: " . $row["usuario"] . " - Rol: " . (empty($row["rol"]) ? "(no asignado)" : $row["rol"]) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No hay usuarios en la base de datos</p>";
}

$conn->close();
?>