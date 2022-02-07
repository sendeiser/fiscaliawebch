<?php

function array2json($data){
   $data = json_encode($data);
   
   $tabCount = 0;
   $result = '';
   $quotes = false;
   $separator = "\t";
   $newLine = "\n";

   for($i=0;$i<strlen($data);$i++){
       $c = $data[$i];
       if($c=='"' && $data[$i-1]!='\\') $quotes = !$quotes;
       if($quotes){
           $result .= $c;
           continue;
       }
       switch($c){
           case '{':
           case '[':
               $result .= $c . $newLine . str_repeat($separator, ++$tabCount);
               break;
           case '}':
           case ']':
               $result .= $newLine . str_repeat($separator, --$tabCount) . $c;
               break;
           case ',':
               $result .= $c;
               if($data[$i+1]!='{' && $data[$i+1]!='[') $result .= $newLine . str_repeat($separator, $tabCount);
               break;
           case ':':
               $result .= $c . ' ';
               break;
           default:
               $result .= $c;
       }
   }
   return  $result;
}

$servidor = "45.236.131.227";
$nombreusuario = "root";
$password = "martin/123";
$db = "Fiscalia";
$conexion = new mysqli($servidor, $nombreusuario, $password, $db);



/*if(isset($_POST['cantidad'])=="cantidad"){
$sql = "SELECT * FROM noticias";
$consulta=mysqli_query($conexion, $sql);
$resp=mysqli_num_rows($consulta);
echo json_encode($resp);
 }

 if($_POST['datos']=="datos"){*/


    $sql = "SELECT * FROM noticias";
    $consulta=mysqli_query($conexion, $sql);



   
   while($fila = mysqli_fetch_assoc($consulta)){
    $datos[]=$fila;
    }

   $arr= var_dump($datos);
    $json = array2json($arr);
    header('Content-Type: application/json; charset=utf-8');
    echo $json;
   
// }


?>