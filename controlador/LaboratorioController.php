<?php
include '../modelo/Laboratorio.php';

$laboratorio = new Laboratorio();

if($_POST['funcion']=="listar"){
    $laboratorio->mostrar();
    $json = array();
    foreach ($laboratorio->laboratorios as $data) {
       $json['data'][]=$data;
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=="editar"){
            $id=$_POST['id'];
            $fechadesalida=$_POST['fechadesalida'];
            $fechadeentrada=$_POST['fechadeentrada'];
            $denunciado=$_POST['denunciado'];
            $comisaria=$_POST['comisaria'];
            $fojas=$_POST['fojas'];
            $librodeactas=$_POST['librodeactas'];
            $nroexpediente=$_POST['nroexpediente'];
            $causa=$_POST['causa'];
            $medida=$_POST['medida'];
   $laboratorio->editar($id,$causa,$medida,$fechadeentrada,$fechadesalida,$comisaria,$nroexpediente,$librodeactas,$fojas,$denunciado);
   
}
if($_POST['funcion']=="eliminar"){
    $id = $_POST['id'];
    $laboratorio->eliminar($id);
    return $laboratorio;
 }
 if($_POST['funcion']=="editar_per"){
   $dni = $_POST['dni'];
   $nombre = $_POST['nombre'];
   $apellido = $_POST['apellido'];
   $laboratorio->editarper($dni,$nombre,$apellido);
   return $laboratorio;
}

 if($_POST['funcion']=="eliminar_per"){
   $id = $_POST['idper'];
   $laboratorio->eliminarper($id);
   return $laboratorio;
}
if($_POST['funcion']=="editar_comi"){
   $id = $_POST['idcomi'];
   $nombre = $_POST['nombrecomi'];
   $telefono = $_POST['telefono'];
   $laboratorio->editarcomi($id,$nombre,$telefono);
   return $laboratorio;
}

if($_POST['funcion']=="eliminar_comi"){
   $id = $_POST['idcomi'];
   $laboratorio->eliminarcomi($id);
   return $laboratorio;
}

if($_POST['funcion']=="nueva_comi"){
   $nombre_comi = $_POST['nombre_comi'];
   $nro_comi = $_POST['nrocominew'];
   $id_comi = $_POST['idcominew'];
   $laboratorio->newcomi($nombre_comi,$nro_comi,$id_comi);
   return $laboratorio;
}

