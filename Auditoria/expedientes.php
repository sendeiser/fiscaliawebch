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

// Consulta para obtener los expedientes
$sql = "SELECT * FROM vista_expedientes";
$result = $conn->query($sql);

$expedientes = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $expediente = array(
            "idexpediente" => $row["idexpediente"],
            "dnidenunciante" => $row["dnidenunciante"],
            "denunciado" => $row["denunciado"],
            "causa" => $row["causa"],
            "medida" => $row["medida"],
            "fojas" => $row["fojas"],
            "librodeactas" => $row["librodeactas"],
            "codigocomisaria" => $row["codigocomisaria"],
            "numerodeexpediente" => $row["numerodeexpediente"],
            "numexpinstru" => $row["numexpinstru"],
            "fechadeentrada" => $row["fechadeentrada"]
        );
        $expedientes[] = $expediente;
    }
}

// Cerrar la conexión
$conn->close();

// Enviar los datos de los expedientes en formato JSON
header('Content-Type: application/json');
echo json_encode($expedientes);
?>