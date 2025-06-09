<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fiscaliach";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener las noticias
$sql = "SELECT * FROM noticias";
$result = $conn->query($sql);

$noticias = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $noticia = array(
            "id" => $row["id"],
            "noticia" => $row["noticia"],
            "imagen" => $row["imagen"],
            "titulo" => $row["titulo"]
        );
        $noticias[] = $noticia;
    }
}

// Cerrar la conexión
$conn->close();

// Enviar los datos de las noticias en formato JSON
header('Content-Type: application/json');
echo json_encode($noticias);
?>