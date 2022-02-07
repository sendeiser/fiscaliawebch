<?php
include("phpserv/connect.php");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Fiscalia - Chamical</title>
     <!--Import Google Icon Font-->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <!-- Compiled and minified CSS -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">-->
   <link rel="stylesheet" href="css/navi.css">
   <link rel="stylesheet" href="css/estilos.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"  rel="stylesheet">
<!-- Google Fonts -->
<link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
<!-- MDB -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css"  rel="stylesheet">

  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Mate+SC&display=swap" rel="stylesheet">
 
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Pattaya&display=swap" rel="stylesheet">
</head>

<body>
  
    <ul class="nav bg-image d-flex justify-content-center" style="background-image: url('images/16982.jpg');">
     
        <nav class="navbar navbar-light bg-light rounded" >
        <div class="container-fluid">
          <a class="navbar-brand" onclick="accion()" href="#"style="font-weight: bold;">
            <img src="images/justicia2.png" alt="" width="40" height="34" class="d-inline-block align-text-top" >
            Fiscalia Web
          </a>
        </div>
      </nav>
      
  
      <li class="nav-item desaparece1">
        <a class="nav-link " aria-current="page" href="#" aria-disabled="false" onclick="accion()">Menu</a>
      </li>
      <li class="nav-item justify-content-right desaparece">
        <a class="nav-link" href="index.html">Inicio</a>
      </li>
      <li class="nav-item justify-content-right desaparece">
        <a class="nav-link" href="#">Comisarias</a>
      </li>
      <li class="nav-item justify-content-right desaparece">
        <a class="nav-link" href="estadodenuncia.php">Estado de su Denuncia</a>
      </li>
      <li class="nav-item desaparece">
        <a class="nav-link" href="registro.html"  aria-disabled="true">Registrar</a>
      </li>
      <li class="nav-item desaparece">
        <a class="nav-link" href="Login.html"  aria-disabled="true">Iniciar Sesion</a>
      </li>
      <li class="nav-item desaparece">
        <a class="nav-link" href="contacto.html"  aria-disabled="true">Contacto</a>
      </li>
    </ul>

    <div class="container"  id="comisaria1">  
        <br> 
        <div class="row" id="comisariafila">
        
            <span id="comisariatitu" class="col-xl-12 border border-success text-light">Informacion de Contacto con tus Comisarias</span>   

        </div>
   <br><br>
   <div class="row" id="comisaria2">
     
    <div class="table-responsive" style="width:auto">
    
      <table class="table table-sm table-hover border border-dark border-5">
        <thead>
          <tr class="table-light fs-2 fw-bold border-bottom border-dark border-2">
            <th scope="col" class="border-end border-dark border-2">Comisarias</th>
            <th scope="col">Telefonos</th>
            
          </tr> 
          <tbody id="exped" class="table-hover fs-4 fw-bold">
        <?php $consult="SELECT nrodetelefono,descripcion FROM comisarias";
        $resul=mysqli_query($conexion,$consult);
        while($row=mysqli_fetch_assoc($resul)){ ?>
              
        <tr class="table-warning " >
              
              <td class="border border-dark border-2"><?php echo $row["descripcion"]?></td>
             
              <td class="border border-dark border-2"><a <?php echo 'href="tel:'.$row["nrodetelefono"].'"'?> ><?php echo $row["nrodetelefono"]?></a></td>
            </tr>
            <?php } mysqli_free_result($resul); ?>  

          </tbody>
        </thead>
        
       </table>
    
     </div>

   </div>

 </div>   
  
    
      

    <!-- Footer -->
    <footer class="page-footer font-small" style="border-top:5px solid rgba(0, 0, 0, 0.555);background-color:#4a3933; color:rgba(202, 159, 159, 0.835);font-size: small;font-weight:bold;height:max-content">

<!-- Copyright -->
<div class="footer-copyright text-center py-3">© 2021 Copyright:
  <a href="" style="color: #f8ecb296;">Fiscalia - Chamical,La Rioja - Argentina</a>
</div>
<!-- Copyright -->

</footer>

      <script>
        function accion(){
           var ancla= document.getElementsByClassName('nav-item');
           for (i = 1; i < ancla.length; i++) {
               ancla[i].classList.toggle('desaparece');
               
           }
        }
      

    </script>

</script>
<!-- Compiled and minified JavaScript -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<!-- MDB -->
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"
></script>

</body>
</html>