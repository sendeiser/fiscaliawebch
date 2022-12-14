<?php
include("connect.php");
$consult="SELECT dnidenunciante,denunciado,causa,medida,fojas,librodeactas,codigocomisaria,numerodeexpediente,fechadeentrada,fechadesalida FROM expedientes";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiscalia - Chamical</title>
         <!--Import Google Icon Font-->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <!-- Compiled and minified CSS -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">-->
   <link rel="stylesheet" href="css/navi.css">
   <link rel="stylesheet" href="css/estilos.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body class="bg-image" style="background-image:url('images/registrar.jpg')">
    <ul class="nav bg-image d-flex justify-content-center" style="background-image:url('images/registrar.jpg')">
          <nav class="navbar navbar-light bg-dark"></nav>
          <nav class="navbar navbar-light bg-light rounded" >
          <div class="container-fluid">
            <a class="navbar-brand" href="grid.html">
              <img src="images/justicia2.png" alt="" width="40" height="34" class="d-inline-block align-text-top">
              Fiscalia Web
            </a>
          </div>
        </nav>
    
        <li class="nav-item desaparece1 aparece">
          <a class="nav-link " aria-current="page" href="#" aria-disabled="false" onclick="accion()">Menu</a>
        </li>
        <li class="nav-item justify-content-right desaparece">
          <a class="nav-link" href="grid.html">Inicio</a>
        </li>
        <li class="nav-item desaparece">
          <a class="nav-link" href="#" aria-disabled="true">Nosotros</a>
        </li>
        <li class="nav-item desaparece">
          <a class="nav-link" href="#"  aria-disabled="true">Registrar</a>
        </li>
        <li class="nav-item desaparece">
          <a class="nav-link" href="Login.html"  aria-disabled="true">Iniciar Sesion</a>
        </li>
        <li class="nav-item desaparece">
          <a class="nav-link" href="#"  aria-disabled="true">Contacto</a>
        </li>
      </ul>



 
      <div class="container"style="height: 25px;"></div>
  
  
    <div class="col-sm-12 col-lg-12 text-center"><label for="" class="registitulo">Consulta de Expedientes</label></div>

  <div class="container"style="height: 70px;"></div>
    
   
<div class="d-flex justify-content-center">
  <div class="table-responsive" style="width:min-content;">

<table class="table table-sm">
  <thead>
    <tr class="table-dark">
      <th scope="col">Denunciante</th>
      <th scope="col">Denunciado</th>
      <th scope="col">Causa</th>
      <th scope="col">Medida</th>
      <th scope="col">Fojas</th>
      <th scope="col">L.A</th>
      <th scope="col">Comisaria</th>
      <th scope="col">Nro.Exp</th>
      <th scope="col">Entrada</th>
      <th scope="col">Salida</th>
    </tr> 
    <tbody>
  <?php $resul=mysqli_query($conexion,$consult);
  while($row=mysqli_fetch_assoc($resul)){ ?>
      <tr class="table-light">
        <td><?php echo $row["dnidenunciante"]?></td>
        <td><?php echo $row["denunciado"]?></td>
        <td><?php echo $row['causa']?></td>
        <td><?php echo $row['medida']?></td>
        <td><?php echo $row['fojas']?></td>
        <td><?php echo $row['librodeactas']?></td>
        <td><?php echo $row['codigocomisaria']?></td>
        <td><?php echo $row['numerodeexpediente']?></td>
        <td><?php echo $row['fechadeentrada']?></td>
        <td><?php echo $row['fechadesalida']?></td>
      </tr>
      <?php } mysqli_free_result($resul); ?>      
    </tbody>
  </thead>
  
  </table>
</div>

</div>
  
 

   
  
    



   
    



  
            
      

     

      
       







<script>
    function accion(){
       var ancla= document.getElementsByClassName('nav-item');
       for (i = 1; i < ancla.length; i++) {
           ancla[i].classList.toggle('desaparece');
           
       }
    }

    </script>
    <!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

</body>
</html>