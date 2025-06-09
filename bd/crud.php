<?php
include('phpserv/connect.php');


$opcion = $_POST['opcion'];
$user_id = $_POST['user_id'];

$dni=$_POST['dni']; 
         
        
$fechadeentrada=$_POST['fechadeentrada'];
$denunciado=$_POST['denunciado'];
$comisaria=$_POST['comisaria'];
$fojas=$_POST['fojas'];
$librodeactas=$_POST['librodeactas'];
$nroexpediente=$_POST['nroexpediente'];
$causa=$_POST['causa'];
$medida=$_POST['medida'];
$fechadesalida=$_POST['fechadesalida'];

switch($opcion){
    case 1:
       $sql = "INSERT INTO expedientes (causa, medida, fechadeentrada, fojas, librodeactas, codigocomisaria, numerodeexpediente,denunciado,fechadesalida) VALUES ('$causa','$medida','$fechadeentrada','$fojas','$librodeactas','$comisaria','$nroexpediente','$denunciado','$fechadesalida')"; 
       $sql2="INSERT INTO personas1 (dnidenunciante, nombre, apellido) VALUE ('$dni','$nombre','$apellido')";  
                    
            $pregunta="SELECT * FROM personas1 WHERE dnidenunciante='$dni'";
            $consulta=mysqli_query($conexion, $pregunta);
            $resp=mysqli_num_rows($consulta);


            if(isset($_POST['dni'])){
              if ($resp==0) {

                  if($conexion->query($sql) == true and $conexion->query($sql2)== true){
                    
                    echo json_encode('personanueva');
                     

                  }else{
                    echo json_encode('Error al insertar datos: '.$conexion->error);
                }

              } else {

                if($conexion->query($sql) == true){
                   
                  echo json_encode('personaregistrada');


                }else{
                    die("Error al insertar datos: " . $conexion->error);
                }

              }
              }       
        break;    
    case 2:        
       $consulta = "UPDATE expedientes SET denunciado='$denunciado',causa='$causa',medida='$medida',fojas='$fojas', WHERE user_id='$user_id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM expedientes WHERE user_id='$user_id' ";       
        $consulta_nm=mysqli_query($conexion,$consulta);
        $data=mysqli_fetch_assoc($consulta_nm);
        break;
    case 3:        
      $consulta = "DELETE FROM expedientes WHERE idexpediente='$user_id' ";		
      if($conexion->query($consulta) === true){
        echo 'EXITOSO';
         }
         else{ 
       die ("Error al insertar datos: " . $conexion->error);
          }
    
      break;   
    }

print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
$conexion=null;