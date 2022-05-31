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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Mate+SC&display=swap" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Pattaya&display=swap" rel="stylesheet">
</head>

<body>

  <nav class="nav bg-image d-flex justify-content-center" style="background-image: url('images/16982.jpg');">

    <ul class="navbar navbar-light bg-light rounded">
      <div class="container-fluid">
        <a class="navbar-brand" onclick="accion()" href="#" style="font-weight: bold;">
          <img src="images/justicia2.png" alt="" width="40" height="34" class="d-inline-block align-text-top">
          Fiscalia Web
        </a>
      </div>
    </ul>

  <ul>

    <li class="nav-item desaparece1">
      <a class="nav-link " aria-current="page" href="#" aria-disabled="false" onclick="accion()">Menu</a>
    </li>
    <li class="nav-item justify-content-right desaparece">
      <a class="nav-link" href="index.html">Inicio</a>
    </li>
    <li class="nav-item justify-content-right desaparece">
      <a class="nav-link" href="comisarias.php">Comisarias</a>
    </li>
    <li class="nav-item justify-content-right desaparece">
      <a class="nav-link" href="estadodenuncia.php">Estado de su Denuncia</a>
    </li>
    <li class="nav-item desaparece">
      <a class="nav-link" href="registro.html" aria-disabled="true">Registrar</a>
    </li>
    <li class="nav-item desaparece">
      <a class="nav-link" href="Login.html" aria-disabled="true">Iniciar Sesion</a>
    </li>
    <li class="nav-item desaparece">
      <a class="nav-link" href="contacto.html" aria-disabled="true">Contacto</a>
    </li>
  </ul>
  </nav>

  <main class="main__denuncia__estado">
    <br>
    <div class="denuncia__titulo">

      <h1  class="registitulo ">Estado de su Denuncia</h1>

    </div>
    <br>


    <div class="" id="denuncia">

      <div class="denuncia__label">
          <p >En esta seccion podra ver el estado en que se encuentra su denuncia</p>
      </div>

      <div class="denuncia__container__form">

        <form action="" method="post" class="">
          <div class="form-floating mb-3 letrasreg  d-block mx-auto">
            <input type="number" class="form-control text-center" name="dni1" id="floatingInput" placeholder="DNI"  style="font-size: 20px;font-weight:bold">
            <label for="floatingInput">Escriba su DNI</label>
          </div>


          <div class="d-grid gap-3 d-flex justify-content-center">
            <a href=""><button class="button rounded" type="reset">Limpiar</button></a>
            <button class="button  rounded" type="submit">Consultar</button>
          </div>
          <div class="container" style="height: 1vh;"></div>

          <?php

          if(isset($_POST['dni1']))
          {
            $dni = $_POST['dni1'];
          

          //  3.- VISUALIZACIÓN DE LOS DATOS
          $query = "SELECT * FROM expedientes WHERE dnidenunciante='$dni'";
          $result = mysqli_query($conexion, $query);
          //$array=mysqli_fetch_array($result); 
        
          while ($row = $result->fetch_array()) {
            $last = end($row);
          }
        
          echo "</ol>";

          if (isset($dni)) {
            if ($last === NULL) { ?>
              <br>
              <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                </symbol>
              </svg>

              <div class="alert alert-primary d-flex align-items-center alert-mod" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                  <use xlink:href="#info-fill" />
                </svg>
                <div>
                  Su denuncia esta proxima a ser procesada a la autoridad correspondiente
                </div>
              </div>
            <?php } else { ?>
              <br>
              <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </symbol>
              </svg>
              <div class="alert alert-success d-flex align-items-center alert-mod"  role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                  <use xlink:href="#check-circle-fill" />
                </svg>
                <div>
                  Su denuncia ya se proceso en Fiscalia y paso al Juzgado el dia: <?php echo "" . $last; ?>
                </div>
              </div>

          <?php }
          }
          mysqli_free_result($result);
        }
          ?>


        </form>

      </div>
      <div class="denuncia__label">
          <p>Solo escriba su DNI para consultar el estado de su denuncia</p>
        </div>
      </div>
    </div>
    <figure class="denuncia__img" id="">
       <img src="/images/denunciajust1.png" alt="justiciadenuncia" width="330" height="330" class="" />
     </figure> 
  </main>




  <!-- Footer -->
  <footer class="page-footer font-small" style="border-top:5px solid rgba(0, 0, 0, 0.555);background-color:#4a3933; color:rgba(202, 159, 159, 0.835);font-size: large;font-weight:bold;height:max-content">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2021 Copyright:
      <a href="" style="color: #f8ecb296;">Fiscalia - Chamical,La Rioja - Argentina</a>
    </div>
    <!-- Copyright -->

  </footer>

  <script>
    function accion() {
      var ancla = document.getElementsByClassName('nav-item');
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
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

</body>

</html>