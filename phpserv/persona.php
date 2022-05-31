<?php           
include('connect.php');



if(isset($_POST['dni'])){

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
}
if(isset($_POST['nroexp'])){

    $nroexp=$_POST['nroexp'];
    $sql1="SELECT * FROM expedientes WHERE numerodeexpediente = '$nroexp'";
    $consulta=mysqli_query($conexion, $sql1);
    $row=mysqli_num_rows($consulta);

    if ($row>0) {
         echo json_encode('si');
     }
     else{
         echo json_encode('no');
     }

}
mysqli_free_result($consulta);
?>