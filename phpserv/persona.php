<?php           include('connect.php');

$dni=$_POST['dni'];
$sql="SELECT * FROM personas1 WHERE dnidenunciante = '$dni'";
$consulta=mysqli_query($conexion,$sql);
$row=mysqli_num_rows($consulta);

if ($row>0) {
   $datos=mysqli_fetch_assoc($consulta);
    echo json_encode($datos);
}
else{
    echo json_encode('no');
}
mysqli_free_result($consulta);
?>