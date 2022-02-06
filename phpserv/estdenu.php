<?php           include('connect.php');

  

                    $dni=$_POST['dni1'];
                    
                    //  3.- VISUALIZACIÓN DE LOS DATOS
                    $query = "SELECT * FROM expedientes WHERE dnidenunciante='$dni'";
                    $result = mysqli_query($conexion, $query);
                    //$array=mysqli_fetch_array($result); 
                       
                    while($row = $result->fetch_array() ) {
                      $last=end($row);
                     }   

                    if(isset($dni)){
                    if ($last==NULL) { 
                             echo json_encode('noprocesada');
                     } else {
                      
                      echo json_encode($last);
                    }
                     }
                     mysqli_free_result($result);
    
                    ?>
