<?php
require 'conexion.php';
date_default_timezone_set("America/Argentina/Buenos_Aires");
setlocale(LC_TIME, 'es_RA.UTF-8','esp');
session_start();

$user = $_SESSION['nombre_usuario'];
$fecha = date("Y-m-d"); // Genera la fecha actual en formato "YYYY-MM-DD"
$hora = date("H:i:s"); // Genera la hora actual en formato "HH:MM:SS"


if (isset($_POST['titu'])){


    if($_POST['img']!=NULL){

        $titu=$_POST['titu'];
        $texto=$_POST['texto'];
        $image=$_POST['img'];
       
        $sql= "INSERT INTO noticias (noticia,imagen,titulo) VALUES ('$texto','images/$image','$titu')";
        $mysqli->query($sql);

        $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario)
        VALUES ('Noticias', 'Se subio una nueva noticia', '$fecha', '$hora', '$user')";
        $mysqli->query($sqlreg);
      
        echo 'si';    
    }   
    else {
        $titu=$_POST['titu'];
        $texto=$_POST['texto'];
        $sql= "INSERT INTO noticias (noticia,imagen,titulo) VALUES ('$texto','images/noti.jpg','$titu')";
        $mysqli->query($sql);
        echo 'no';
    }

}



if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

 
    $file = $_FILES['inp-img']['name'];

    //$extension = explode(".", $file);

    $nombre_archivo = $file;

    $existepath = '../images/'.$file;

    if(file_exists($existepath)){
       unlink($existepath);     //borra en caso de que exista
        }
    
    
        if ($file && move_uploaded_file($_FILES['inp-img']['tmp_name'], "../images/" . $nombre_archivo)) {

            //sleep(3); //retraso la petición en 3 segundos para la subida
        
            echo json_encode('exito');

        }else{ echo json_encode('ERROR EN LA SUBIDA');}
}





?>