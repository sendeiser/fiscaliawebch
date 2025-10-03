<?php
include("phpserv/connect.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Comisarías - Fiscalía Chamical</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <!-- CSS Frameworks -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/modern-design.css">
  <link rel="stylesheet" href="css/new-navbar.css">
  <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
  <!-- Navigation -->
  <nav class="fiscal-navbar">
    <div class="fiscal-navbar-container">
      <a href="index.html" class="fiscal-navbar-brand">
        <img src="images/justicia2.png" alt="Logo Fiscalía">
        <span>Fiscalía Web</span>
      </a>
      
      <button class="fiscal-navbar-toggle" aria-label="Toggle navigation" aria-expanded="false">
        <i class="fas fa-bars"></i>
      </button>
      
      <ul class="fiscal-navbar-nav">
        <li class="fiscal-navbar-item">
          <a class="fiscal-navbar-link" href="index.html">
            <i class="fas fa-home me-1"></i>Inicio
          </a>
        </li>
        <li class="fiscal-navbar-item">
          <a class="fiscal-navbar-link" href="comisarias.php">
            <i class="fas fa-building me-1"></i>Comisarías
          </a>
        </li>
        <li class="fiscal-navbar-item">
          <a class="fiscal-navbar-link" href="estadodenuncia.php">
            <i class="fas fa-search me-1"></i>Estado de denuncia
          </a>
        </li>
        <li class="fiscal-navbar-item">
          <a class="fiscal-navbar-link" href="registro.html">
            <i class="fas fa-user-plus me-1"></i>Registrarse
          </a>
        </li>
        <li class="fiscal-navbar-item">
          <a class="fiscal-navbar-link" href="Login.html">
            <i class="fas fa-sign-in-alt me-1"></i>Iniciar sesión
          </a>
        </li>
        <li class="fiscal-navbar-item">
          <a class="fiscal-navbar-link" href="contacto.html">
            <i class="fas fa-envelope me-1"></i>Contacto
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section" style="background: var(--gradient-primary); min-height: 40vh; display: flex; align-items: center;">
    <div class="container">
      <div class="row align-items-center text-center">
        <div class="col-12 fade-in-up">
          <h1 class="display-4 text-white fw-bold mb-4">
            <i class="fas fa-building me-3"></i>Comisarías de la Región
          </h1>
          <p class="lead text-white-50 mb-0">
            Información de contacto y ubicación de las comisarías disponibles
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <main class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card border-0 shadow-lg glass-effect">
          <div class="card-header bg-transparent border-0 text-center py-4">
            <h3 class="fw-bold text-gradient mb-0">
              <i class="fas fa-phone me-2"></i>Información de Contacto
            </h3>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-dark">
                  <tr>
                    <th scope="col" class="py-3 px-4">
                      <i class="fas fa-building me-2"></i>Comisarías
                    </th>
                    <th scope="col" class="py-3 px-4">
                      <i class="fas fa-phone me-2"></i>Teléfonos
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $consult = "SELECT nrodetelefono,descripcion FROM comisarias";
                  $resul = mysqli_query($conexion, $consult);
                  while ($row = mysqli_fetch_assoc($resul)) { ?>
                    <tr class="hover-lift-subtle">
                      <td class="py-3 px-4 fw-semibold">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        <?php echo $row["descripcion"] ?>
                      </td>
                      <td class="py-3 px-4">
                        <a href="tel:<?php echo $row['nrodetelefono'] ?>" 
                           class="btn btn-outline-success btn-sm hover-lift">
                          <i class="fas fa-phone me-1"></i>
                          <?php echo $row["nrodetelefono"] ?>
                        </a>
                      </td>
                    </tr>
                  <?php }
                  mysqli_free_result($resul); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        
        <!-- Additional Info Card -->
        <div class="row mt-4">
          <div class="col-md-6 mb-3">
            <div class="card border-0 shadow hover-lift h-100">
              <div class="card-body text-center p-4">
                <i class="fas fa-clock fa-2x text-primary mb-3"></i>
                <h5 class="fw-bold mb-3">Horarios de Atención</h5>
                <p class="text-muted mb-0">Lunes a Viernes: 8:00 - 16:00</p>
                <p class="text-muted mb-0">Emergencias: 24 horas</p>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card border-0 shadow hover-lift h-100">
              <div class="card-body text-center p-4">
                <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                <h5 class="fw-bold mb-3">Emergencias</h5>
                <p class="text-muted mb-2">Para emergencias llame al:</p>
                <a href="tel:911" class="btn btn-danger btn-lg">
                  <i class="fas fa-phone me-2"></i>911
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="page-footer font-small" style="background: var(--gradient-primary); color: white;">
    <div class="footer-copyright text-center py-4">
      <div class="container">
        <p class="mb-0">
          © 2024 Copyright: 
          <a href="#" class="text-white text-decoration-none fw-bold hover-lift">
            Fiscalía - Chamical, La Rioja - Argentina
          </a>
        </p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

  <script>
    function accion() {
      var ancla = document.getElementsByClassName('nav-item');
      for (i = 1; i < ancla.length; i++) {
        ancla[i].classList.toggle('desaparece');
      }
    }

    // Smooth scrolling and animations
    document.addEventListener('DOMContentLoaded', function() {
      // Add loading animations on scroll
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }
        });
      }, observerOptions);

      document.querySelectorAll('.fade-in-up, .hover-lift').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        observer.observe(el);
      });
    });
  </script>
  
  <!-- Navbar Script -->
  <script src="js/new-navbar.js"></script>
</body>

</html>