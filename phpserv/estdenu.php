<?php           include('connect.php');

  

                    $dni=$_POST['dni1'];
                    
                    //  3.- VISUALIZACIÓN DE LOS DATOS
                   
                    //$array=mysqli_fetch_array($result); 
                    /* $row=mysqli_num_rows($result); */


                    
                    if(isset($dni)){
                      $query = "SELECT * FROM expedientes WHERE dnidenunciante='$dni'";
                      $result = mysqli_query($conexion, $query);
                      
                      $exist=mysqli_num_rows($result);

                      if($exist > 0)
                      {
                        while($row = $result->fetch_array() ) {
                          $last=end($row);
                         }   

                         if ($last==NULL) { 
                                  echo json_encode('noprocesada');
                          } else {
                           
                           echo json_encode($last);
                         }
                          }
                      else
                      {
                        echo json_encode('dninoexiste');
                      }   
                      }
                     
         mysqli_free_result($result);
    
                    ?>
