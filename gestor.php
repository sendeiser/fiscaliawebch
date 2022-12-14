

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiscalia - Chamical</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="css/tablaper.css">
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body class="">
                                      <!--PARTE DE ARRIBA-->
<ul class="nav bg-image d-flex justify-content-center" style="background-image: url('images/16982.jpg');">

      <nav class="navbar navbar-light bg-light rounded border border-2 border-dark" >
        <div class="container-fluid text-center">
          <a class="navbar-brand" style="font-weight:bold" href="index.html">
            <img src="images/justicia2.png" alt="" width="40" height="32" class="">
            Fiscalia Web
          </a>
        </div>
      </nav>

   <div class="row d-flex align-self-center">   
   <div class="col-sm-12 d-flex"><span class="MenuAdm rounded border border-warning border-4 text-center" style="font-weight:bold; font-size:xx-large;color:#f8dc81" >Menu de Gestion del Sistema</span></div>
    </div>  
       </ul>
    
<div class="row" >
        
  <!--COLUMNA DEL CONTENEDOR DEL MENU-->
    <div class="col-md-12 col-sm-12 col-lg-2 col-xl-2 border border-1 border-dark rounded-3 d-block mx-auto" id="menugestor" style="background-image:url('images/menuabs.jpg')">

    
          <div class="container "style="height: 10vh; width:100%"></div>
          
          <nav class="nav flex-column col-md-12 col-sm-12 col-lg-12 ">
            
            <a class="nav-link1 border text-center" href="#" onclick="regexpe()">Registrar Expedientes</a>
            
            <div class="container "style="height: 40px; width:100%"></div>

            <a class="nav-link1 border text-center" href="#" onclick="estdenun()">Estado de la Denuncia</a>

            <div class="container "style="height: 40px; width:100%"></div>

            <a class="nav-link1 border text-center" href="#" onclick="salida()">Registrar Salida</a>

            <div class="container "style="height: 40px; width:100%"></div>

            <a class="nav-link1 border text-center" href="#" onclick="consexpe()">Expedientes</a>

            <div class="container "style="height: 40px; width:100%"></div>

            <a class="nav-link1 border text-center" href="#" onclick="person()">Personas Registradas</a>

            <div class="container "style="height: 40px; width:100%"></div>

            <a class="nav-link1 active border text-center" onclick="comi()" aria-current="page" href="#" >Comisarias</a>

            <div class="container "style="height: 40px; width:100%"></div>

          </nav>
    </div>

    <nav id="menucel"class="navbar navbar-expand navbar-dark bg-dark " >
      <div class="container-fluid ">        
       
      
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                MENU
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                <li><a class="dropdown-item" href="#" onclick="comi()">Comisarias</a></li>
                <li><a class="dropdown-item" href="#" onclick="estdenun()">Estado de la Denuncia</a></li>
                <li><a class="dropdown-item" href="#" onclick="regexpe()">Registrar Expediente</a></li>
                <li><a class="dropdown-item" href="#" onclick="salida()">Registrar Salida</a></li>
                <li><a class="dropdown-item" href="#" onclick="consexpe()">Expedientes</a></li>
                <li><a class="dropdown-item" href="#" onclick="person()">Personas</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
       
        
         
       <!--COLUMNA DEL CONTENEDOR DE LOS FORMULARIOS --> 
       <div id="gestor" class="col-md-12 col-sm-12 col-lg-10  d-flex justify-content-center rounded-3" style="background-image:url('images/fondocont.jpg')">
          
            
  
      <!-- FORMULARIOS DEL CONTENEDOR -->   

      <div id="estden" class="row col-xl-9 col-lg-9 col-md-11 col-sm-10 col-12 border d-flex justify-content-center mt-5 invisible" style="position: absolute;height: 50%;">

              <div class="container p-1 " style="background-color:#f5e6ca">

                <div class="row d-flex justify-content-center">
                  <label for="" class="col-10 badge bg-primary bg-gradient text-center fs-3 fw-bold rounded rounder-4">Estado de las Denuncias</label>
                </div>
              <form action="" method="POST" id="form-denu">

                  <div class="row d-flex justify-content-center mt-4" >
                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-7">
                      <div class="input-group input-group-lg">
                        <span class="input-group-text bg-dark text-light fw-bold" id="spandni">DNI</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="spandni" id="input-d" name="dni1">
                      </div>             
                    </div>
                  </div>

                  <div class="row d-flex justify-content-center mt-3">
                    <button id="btn-d" type="submit" class="btn btn-light fw-bold fs-6 col-xl-2 col-lg-2 col-md-3 col-sm-3 col-4 border border-dark">Consultar</button>
                  </div>
              </form>

            <div class="row d-flex justify-content-center mt-3">
              <span class="col-10 badge bg-dark ">Digite el DNI de la persona para saber el estado de la SALIDA</span>
            </div>

            <div class="row d-flex justify-content-center mt-4" >
                <div class="col-9" id="respuesta-d"> </div>
            </div>

        </div>
      </div>
      
      <form action="" id="regexp" method ="post" class="row mt-5 g-2 col-xl-9 col-lg-9 col-md-11 col-sm-11 col-11 bg-light d-flex justify-content-center border border-2 border-primary invisible" style="position:absolute ">

        
          <label for="" class="registitulo text-center" style="height: min-content;margin-bottom:-15px">Registro de Expedientes</label>

        <div class="container d-grid d-flex justify-content-center" style="height: 4vh;font-weight: bold; font-size: 26px;"><span><u>Denunciante</u></span></div>
          
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-10">
             <div class="form-floating mb-3 letrasreg">
              <input type="text" class="form-control"  name="nombre" id="floatingInput" placeholder="Nombre">
              <label for="floatingInput">Nombre</label>
            </div> 
          </div>
        
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-10">
            <div class="form-floating mb-3 letrasreg">
              <input type="text" class="form-control"  name="apellido" id="floatingInput" placeholder="Apellido">
              <label for="floatingInput">Apellido</label>
            </div> 
          </div>

          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-10">
            <div class="form-floating mb-3 letrasreg">
              <input type="number" class="form-control"  name="dni" id="floatingInput" placeholder="DNI" required>
              <label for="floatingInput">DNI</label>
            </div> 
          </div>

          <div class="container d-grid d-flex justify-content-center" style="height: 4vh;font-weight: bold; font-size: 26px;margin-top: -20px"><span><u>Denunciado</u></span></div>

          <div class="col-xl-5 col-md-7 col-sm-9 col-lg-6 col-10">
            <div class="form-floating mb-3 letrasreg">
             <input type="text" class="form-control"  name="denunciado" id="floatingInput" placeholder="Nombre" required>
             <label for="floatingInput" >Nombre Completo</label>
           </div> 
         </div>

         <div class="container d-grid d-flex justify-content-center" style="height: 4vh;font-weight: bold; font-size: 26px;margin-top: -20px"><span><u>Datos a Complementar</u></span></div>
         
         
         
         <div class="col-xl-2 col-md-4 col-sm-4 col-lg-2 col-5">
           <div class="form-floating mb-3 letrasreg">
             <input type="number" class="form-control"  name="fojas" id="floatingInput" placeholder="Fojas" required>
             <label for="floatingInput">Fojas</label>
            </div> 
          </div>
          

          <div class="col-xl-2 col-md-4 col-sm-4 col-lg-3 col-5">
            <div class="form-floating mb-3 letrasreg">
              <input type="number" class="form-control"  name="librodeactas" id="floatingInput" placeholder="Libro de Actas" required>
              <label for="floatingInput">Libro de Actas</label>
            </div> 
          </div>
          
          <div class="col-xl-2 col-md-4 col-sm-4 col-lg-4 col-5">
            <div class="form-floating mb-3 letrasreg">
              <input type="number" class="form-control"  name="nroexpediente" id="floatingInput" placeholder="Numero de Expediente" required>
              <label for="floatingInput">Nro.Expediente</label>
            </div> 
          </div>

          
          
          <div class="col-xl-2 col-md-4 col-sm-4 col-lg-3 col-5">
           <div class="form-floating mb-3 letrasreg">
             <input type="number" class="form-control"  name="comisaria" id="floatingInput" placeholder="Comisaria" required>
             <label for="floatingInput">Comisaria</label>
           </div> 
         </div>
 
         <div class="col-xl-2 col-md-4 col-sm-4 col-lg-3 col-5">
           <div class="form-floating mb-3 letrasreg">
             <input type="text" class="form-control"  name="causa" id="floatingInput" placeholder="Causa" required>
             <label for="floatingInput">Causa</label>
           </div> 
         </div>
 
         <div class="col-xl-3 col-md-4 col-sm-4 col-lg-3 col-5">
           <div class="form-floating mb-3 letrasreg">
             <input type="text" class="form-control"  name="medida" id="floatingInput" placeholder="Medida" required>
             <label for="floatingInput">Medida</label>
           </div> 
         </div>
        <div class="col-md-4 col-sm-6 col-lg-4 col-10">
          <div class="form-floating mb-3 letrasreg">
            <input type="date" class="form-control"  name="fechadeentrada" id="floatingInput" placeholder="FechaEntrada" required>
            <label for="floatingInput">Fecha de Entrada</label>
          </div> 
        </div>

             
              <div class="d-grid gap-3 d-flex justify-content-center">
            <a href=""><button class="button rounded" type="reset">Limpiar</button></a>  
              <button id="btn-exp" class="button  rounded" type="submit">Registrar</button>
              </div>
              <div class="container" style="height: 2vh;"></div>

         <div class="row">
           <div id="resp-exp" class="col-9">

           </div>

         </div>              
      </form>

      <div id="consexp" class="row col-xl-9 col-lg-9 col-md-10 col-sm-11 col-12 invisible" style="position: absolute;">
        
            <iframe  src="tablaexp.html"  frameborder="0" style="height: 100vh" allowfullscreen ></iframe> 
          
           
      </div>

      <div id="consper"  class="row col-xl-9 col-lg-9 col-md-10 col-sm-11 col-12 d-flex justify-content-center invisible" style="position:absolute;" > 

       <iframe  src="tablaprueba.html"  frameborder="0"  style="height: 100vh;width:100vw" allowfullscreen ></iframe> 

      </div>  

      <div id="expsali" class="row col-xl-9 col-lg-9 col-md-11 col-sm-10 col-12 border d-flex justify-content-center mt-5 border border-dark" style="position: absolute;height: 50%;">

        <div class="container p-1 " style="background-color:#f5e6ca">

          <div class="row d-flex justify-content-center">
            <label for="" class="col-10 badge bg-dark bg-gradient text-center fs-3 fw-bold rounded rounder-4">Registro de Salida del Expediente</label>
          </div>
        <form action="" method="POST" id="form-sali">

            <div class="row d-flex justify-content-center mt-4" >
              <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-7">
                <div class="input-group input-group-lg">
                  <span class="input-group-text bg-dark text-light fw-bold" id="spandni">DNI</span>
                  <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="spandni" id="input-dni" name="dni1">
                </div>             
              </div>
            </div>
            <div class="row d-flex justify-content-center mt-4" >
              <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-7">
                <div class="input-group input-group-lg">
                  <span class="input-group-text bg-dark text-light fw-bold" id="sali">SALIDA</span>
                  <input type="date" class="form-control" aria-label="Sizing example input" aria-describedby="spansalida" id="input-salida" name="fecha_salida">
                </div>             
              </div>
            </div>

                  <div class="row d-flex justify-content-center mt-3">
                    <button id="btn_salida" type="submit" class="btn btn-light fw-bold fs-6 col-xl-2 col-lg-2 col-md-3 col-sm-3 col-4 border border-dark">CARGAR</button>
                  </div>
              </form>

            
              

                <div class="container-fluid d-flex justify-content-center mt-3">
                  <span class="badge d-flex justify-content-center bg-dark bg-gradient col-sm-12 col-12" style="font-size:small">Digite el DNI de la persona y la fecha de salida para cargarla en la base de datos</span>
  
                </div>
              
            

            <div class="row d-flex justify-content-center mt-4" >
                <div class="col-9" id="respuesta-salida"> </div>
            </div>

        </div>
      </div>

      <div id="comisaria"  class="row col-xl-9 col-lg-9 col-md-10 col-sm-11 col-12 d-flex justify-content-center invisible" style="position:absolute;" > 

        <iframe  src="tablacomi.html"  frameborder="0"  style="height: 100vh;width:100vw" allowfullscreen ></iframe> 
 
       </div>  
    

      
    

    

   </div>                        
        
</div>


  <!-- Footer -->
  <footer class="page-footer font-small cyan" style="background-image:url('/images/foot.jpg'); color:#ffff;font-size: x-large;font-weight:bold">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2021 Copyright:
      <a href="" style="color: #f8f4e1;">Fiscalia - Chamical,La Rioja - Argentina</a>
    </div>
    <!-- Copyright -->
 </footer>
<!-- Footer -->
 

<!--Funciones del Menu-->
  <script>

    function regexpe(){
      var form = document.getElementById("regexp"); form.classList.remove("invisible");
      var form1 = document.getElementById("estden"); form1.classList.add("invisible");  
      var form2 = document.getElementById("consexp"); form2.classList.add("invisible");
      var form3 = document.getElementById("consper"); form3.classList.add("invisible"); 
      var form4 = document.getElementById("expsali"); form4.classList.add("invisible");
      var form5 = document.getElementById("comisaria"); form5.classList.add("invisible");
    }
    function estdenun(){
      var form = document.getElementById("estden"); form.classList.remove("invisible");
      var form1 = document.getElementById("regexp"); form1.classList.add("invisible"); 
      var form2 = document.getElementById("consexp"); form2.classList.add("invisible"); 
      var form3 = document.getElementById("consper"); form3.classList.add("invisible");
      var form4 = document.getElementById("expsali"); form4.classList.add("invisible");
      var form5 = document.getElementById("comisaria"); form5.classList.add("invisible");
    }
    function consexpe(){
      var form = document.getElementById("consexp"); form.classList.remove("invisible");
      var form1 = document.getElementById("estden"); form1.classList.add("invisible"); 
      var form2 = document.getElementById("regexp"); form2.classList.add("invisible");
      var form3 = document.getElementById("consper"); form3.classList.add("invisible");
      var form4 = document.getElementById("expsali"); form4.classList.add("invisible"); 
      var form5 = document.getElementById("comisaria"); form5.classList.add("invisible");
      datatable.ajax.reload(null, false);

    }
    function person(){
      var form3 = document.getElementById("consper"); form3.classList.remove("invisible"); 
      var form = document.getElementById("consexp"); form.classList.add("invisible");
      var form1 = document.getElementById("estden"); form1.classList.add("invisible"); 
      var form2 = document.getElementById("regexp"); form2.classList.add("invisible");
      var form4 = document.getElementById("expsali"); form4.classList.add("invisible");   
      var form5 = document.getElementById("comisaria"); form5.classList.add("invisible"); 
      tablapersonas.ajax.reload(null, false);
    }

    function salida(){
      var form4 = document.getElementById("expsali"); form4.classList.remove("invisible"); 
      var form = document.getElementById("consexp"); form.classList.add("invisible");
      var form1 = document.getElementById("estden"); form1.classList.add("invisible"); 
      var form2 = document.getElementById("regexp"); form2.classList.add("invisible");
      var form3 = document.getElementById("consper"); form3.classList.add("invisible");
      var form5 = document.getElementById("comisaria"); form5.classList.add("invisible");

    }
    function comi(){
      var form = document.getElementById("regexp"); form.classList.add("invisible");
      var form1 = document.getElementById("estden"); form1.classList.add("invisible");  
      var form2 = document.getElementById("consexp"); form2.classList.add("invisible");
      var form3 = document.getElementById("consper"); form3.classList.add("invisible"); 
      var form4 = document.getElementById("expsali"); form4.classList.add("invisible");
      var form5 = document.getElementById("comisaria"); form5.classList.remove("invisible");
      tablacomi.ajax.reload(null, false);
    }



  </script>




<script src="/js/main.js"></script>
<script src="/js/tablaper.js"></script>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <!-- jquery y bootstrap -->
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>   
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
 
 <!-- datatables con bootstrap -->
 <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

 <!-- Para usar los botones -->
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>


<!-- Para los estilos en Excel     -->
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.templates.min.js"></script>

<!-- Responsive DataTable   -->
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>





</body>
</html>