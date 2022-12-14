<?php
	        
            $servidor = "localhost";
            $nombreusuario = "root";
            $password = "martin/123";
            $db = "Fiscalia";
        
            $conexion = new mysqli($servidor, $nombreusuario, $password, $db);
            $conexion->set_charset('utf8');
            if($conexion->connect_error){
                die("Conexión fallida: " . $conexion->connect_error);
            }
            $dni=$_POST['dni'];
            $fechaentrada=$_POST['fechaentrada'];
            $fechasalida=$_POST['fechasalida'];

           $sql="UPDATE expedientes SET fechadesalida = '$fechasalida' WHERE dnidenunciante='$dni' and fechadeentrada='$fechaentrada'";
           if($conexion->query($sql) === true){
            echo 'La fecha de salida fue registrada exitosamente';
        }else{
            die("Error al insertar datos: " . $conexion->error);
        }
        $conexion->close();
    

?>