       <?php
            $servidor = "localhost";
            $nombreusuario = "root";
            $password = "martin/123";
            $db = "Fiscalia";
        
            $conexion = new mysqli($servidor, $nombreusuario, $password, $db);
            $conexion->set_charset('utf8');//Para las ñ y los acentos
            if($conexion->connect_error){
                die("Conexión fallida: " . $conexion->connect_error);
            }

           

                                             
            
                $nombre=$_POST['nombre']; 
                $apellido=$_POST['apellido'];
                $dni=$_POST['dni'];         
                               
                $fechadeentrada=$_POST['fechadeentrada'];
                $denunciado=$_POST['denunciado'];
                $comisaria=$_POST['comisaria'];
                $fojas=$_POST['fojas'];
                $librodeactas=$_POST['librodeactas'];
                $nroexpediente=$_POST['nroexpediente'];
                $causa=$_POST['causa'];
                $medida=$_POST['medida'];

                $sql = "INSERT INTO expedientes (causa, medida, fechadeentrada, fechadesalida, fojas, librodeactas, codigocomisaria, numerodeexpediente, dnidenunciante, numexpinstru,denunciado) VALUES ('$causa','$medida','$fechadeentrada',null,'$fojas','$librodeactas','$comisaria','$nroexpediente','$dni',null,'$denunciado')";
                $sql2="INSERT INTO personas1 (dnidenunciante, nombre, apellido) VALUE ('$dni','$nombre','$apellido')";  
                         
                $pregunta="SELECT * FROM personas1 WHERE dnidenunciante='$dni'";
                $consulta=mysqli_query($conexion, $pregunta);
                $resp=mysqli_num_rows($consulta); 

             if ($resp==0) {

                 if($conexion->query($sql) == true and $conexion->query($sql2)== true){
                    echo 'Los datos fueron agregados exitosamente';
                }else{
                    die("Error al insertar datos: " . $conexion->error);
                }

             } else {

                if($conexion->query($sql) == true){
                    echo 'Los datos fueron agregados exitosamente';
                }else{
                    die("Error al insertar datos: " . $conexion->error);
                }

             }
             
             $conexion->close()

        ?>
  