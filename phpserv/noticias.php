<?php




$servidor = "localhost";
$nombreusuario = "root";
$password = "martin/123";
$db = "Fiscalia";
$conexion = new mysqli($servidor, $nombreusuario, $password, $db);
$conexion->set_charset('utf8');




    $sql = "SELECT noticia,imagen,titulo FROM noticias ORDER BY id DESC";
    $consulta=mysqli_query($conexion, $sql);


   
   
   while($fila = mysqli_fetch_assoc($consulta)){
    $dato[]=$fila;
   }
  
    
   echo json_encode($dato);

  
   



      
 






/*$json.=($json==""?"":",")."{id: '".$datas['id']."',"; // Identificador1 indice o nombre de columna; esto para texto
  $json.="noticia: ".$datas['noticia'].","; // Identificador2 indice o nombre de columna; esto para un numero o valor booleano (true o false)
  // lo demas necesario
  $json.="titulo: ".$datas['titulo'].",";
  $json.="imagen: ".$datas['imagen']."}";*/
// }


?>
