       <?php
	        
            $servidor = "localhost";
            $nombreusuario = "root";
            $password = "martin/123";
            $db = "Fiscalia";
        
            $conexion = new mysqli($servidor, $nombreusuario, $password, $db);
        
            if($conexion->connect_error){
                die("Conexión fallida: " . $conexion->connect_error);
            }

            
            
            if(isset($_POST['nombre'])){
                $nombre=$_POST['nombre'];
                $apellido=$_POST['apellido'];
                $celular=$_POST['celular'];
                $correo=$_POST['correo'];
                $usuario=$_POST['usuario'];
                $contrasena=$_POST['contrasena'];

                $sql = "INSERT INTO Usuarios (Nombre, Apellido, Celular, Correo, Usuario, Contrasena) VALUES ('$nombre','$apellido','$celular','$correo','$usuario','$contrasena')";
				
                $conexion->set_charset('utf8');
                if($conexion->query($sql) === true){
                    echo 'Los datos fueron agregados exitosamente';
                }else{
                    die("Error al insertar datos: " . $conexion->error);
                }
                $conexion->close();
            }

        ?>
  