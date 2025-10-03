<?php include 'phpserv/connect.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Denuncia - Sistema de Gestión de Denuncias Fiscalía</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="css/modern-design.css">
    <link rel="stylesheet" href="css/new-navbar.css">
    <link rel="stylesheet" href="css/estilos.css">
    
    <!-- Bootstrap & External Libraries -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css">
    
    <style>
        :root {
            --primary-blue: #1976d2;
            --secondary-blue: #2196f3;
            --light-blue: #e3f2fd;
            --accent-color: #0d47a1;
            --bg-light: #f8f9fa;
            --bg-white: #ffffff;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --border-light: #e9ecef;
            --shadow-light: rgba(0, 0, 0, 0.1);
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 50%, #bbdefb 100%);
            color: var(--text-dark);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        
        .status-hero {
            background: linear-gradient(135deg, rgba(25, 118, 210, 0.9) 0%, rgba(33, 150, 243, 0.8) 100%), 
                        url('images/justicia.jpg') center/cover;
            padding: 120px 0 80px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .status-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(25, 118, 210, 0.2);
            z-index: 0;
        }
        
        .status-hero-content {
            position: relative;
            z-index: 1;
        }
        
        .status-form-container {
            background: var(--bg-white);
            border: 1px solid var(--border-light);
            border-radius: 20px;
            padding: 40px;
            margin: -60px auto 60px;
            max-width: 600px;
            box-shadow: 0 10px 30px var(--shadow-light);
            position: relative;
            z-index: 2;
        }
        
        .form-group label {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .form-control {
            background: var(--bg-white);
            border: 2px solid var(--border-light);
            border-radius: 12px;
            padding: 15px 20px;
            font-size: 16px;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }
        
        .form-control::placeholder {
            color: var(--text-muted);
        }
        
        .form-control:focus {
            background: var(--light-blue);
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
            color: var(--text-dark);
        }
        
        .btn-search {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            border: none;
            border-radius: 12px;
            padding: 15px 40px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            width: 100%;
            box-shadow: 0 5px 15px rgba(25, 118, 210, 0.3);
        }
        
        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(25, 118, 210, 0.4);
            color: white;
        }
        
        .status-result {
            background: var(--bg-white);
            border: 1px solid var(--border-light);
            border-radius: 20px;
            padding: 30px;
            margin: 30px auto;
            max-width: 800px;
            box-shadow: 0 8px 25px var(--shadow-light);
        }
        
        .status-card {
            background: var(--light-blue);
            border: 1px solid rgba(25, 118, 210, 0.2);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px var(--shadow-light);
            border-left: 5px solid var(--primary-blue);
            transition: all 0.3s ease;
        }
        
        .status-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--shadow-light);
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
        }
        
        .status-active {
            background: linear-gradient(135deg, var(--success-color), #1e7e34);
            color: white;
        }
        
        .status-pending {
            background: linear-gradient(135deg, var(--warning-color), #e0a800);
            color: #212529;
        }
        
        .status-closed {
            background: linear-gradient(135deg, var(--danger-color), #bd2130);
            color: white;
        }
        
        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin: 60px 0;
        }
        
        .info-card {
            background: var(--bg-white);
            border: 1px solid var(--border-light);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px var(--shadow-light);
        }
        
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px var(--shadow-light);
            border-color: var(--primary-blue);
        }
        
        .info-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 24px;
            box-shadow: 0 3px 10px rgba(25, 118, 210, 0.3);
        }
        
        .alert-warning {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
            color: var(--text-dark);
        }
        
        h1, h3, h4, h5 {
            color: var(--text-dark);
        }
        
        .status-hero h1 {
            color: white;
        }
        
        .status-result h3 {
            color: var(--text-dark);
        }
        
        .status-card h5 {
            color: var(--text-dark);
        }
        
        .lead {
            color: rgba(255, 255, 255, 0.95);
        }
        
        .modern-footer {
            background: var(--accent-color) !important;
            color: white !important;
            padding: 40px 0;
            margin-top: 60px;
        }
        
        .modern-footer .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        @media (max-width: 768px) {
            .status-hero {
                padding: 100px 0 60px;
            }
            
            .status-form-container {
                margin: -40px 20px 40px;
                padding: 30px 20px;
            }
            
            .info-cards {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
    </style>
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
    <section class="status-hero">
        <div class="status-hero-content">
            <div class="container">
                <h1 class="display-4 font-weight-bold mb-4">
                    <i class="fas fa-search mr-3"></i>
                    Consulta el Estado de tu Denuncia
                </h1>
                <p class="lead mb-0">
                    Ingresa tu número de DNI para conocer el estado actual de tu denuncia
                </p>
            </div>
        </div>
    </section>

    <!-- Search Form -->
    <div class="container">
        <div class="status-form-container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="dni" class="font-weight-bold mb-3">
                        <i class="fas fa-id-card mr-2"></i>
                        Número de DNI
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="dni" 
                           name="dni" 
                           placeholder="Ingrese su número de DNI" 
                           required
                           pattern="[0-9]{7,8}"
                           title="Ingrese un DNI válido (7-8 dígitos)">
                </div>
                <button type="submit" class="btn btn-search">
                    <i class="fas fa-search mr-2"></i>
                    Consultar Estado
                </button>
            </form>
        </div>

        <!-- PHP Results -->
        <?php
        if ($_POST) {
            $dni = $_POST['dni'];
            $sql = "SELECT * FROM expedientes WHERE dni = '$dni'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="status-result">';
                echo '<h3 class="text-center mb-4"><i class="fas fa-file-alt mr-2"></i>Resultados de la Consulta</h3>';
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $statusClass = 'status-pending';
                    $statusText = $row['estado'];
                    
                    if (strtolower($row['estado']) == 'activo' || strtolower($row['estado']) == 'en proceso') {
                        $statusClass = 'status-active';
                    } elseif (strtolower($row['estado']) == 'cerrado' || strtolower($row['estado']) == 'finalizado') {
                        $statusClass = 'status-closed';
                    }
                    
                    echo '<div class="status-card">';
                    echo '<div class="row">';
                    echo '<div class="col-md-8">';
                    echo '<h5 class="mb-3"><i class="fas fa-folder-open mr-2"></i>Expediente N° ' . $row['id'] . '</h5>';
                    echo '<p class="mb-2"><strong>DNI:</strong> ' . $row['dni'] . '</p>';
                    echo '<p class="mb-2"><strong>Fecha:</strong> ' . date('d/m/Y', strtotime($row['fecha'])) . '</p>';
                    if (!empty($row['descripcion'])) {
                        echo '<p class="mb-2"><strong>Descripción:</strong> ' . $row['descripcion'] . '</p>';
                    }
                    echo '</div>';
                    echo '<div class="col-md-4 text-right">';
                    echo '<span class="status-badge ' . $statusClass . '">' . $statusText . '</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<div class="status-result text-center">';
                echo '<div class="alert alert-warning" role="alert">';
                echo '<i class="fas fa-exclamation-triangle fa-2x mb-3"></i>';
                echo '<h4>No se encontraron resultados</h4>';
                echo '<p class="mb-0">No se encontraron denuncias asociadas al DNI ingresado.</p>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>

        <!-- Information Cards -->
        <div class="info-cards">
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h4>Horarios de Atención</h4>
                <p class="text-muted mb-0">
                    Lunes a Viernes: 8:00 - 16:00<br>
                    Sábados: 8:00 - 12:00
                </p>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <h4>Contacto Directo</h4>
                <p class="text-muted mb-0">
                    Teléfono: (0362) 444-5555<br>
                    Email: consultas@fiscaliachaco.gov.ar
                </p>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h4>Información Importante</h4>
                <p class="text-muted mb-0">
                    Mantenga su DNI actualizado para recibir notificaciones sobre el estado de su denuncia.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="modern-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Fiscalía Chamical</h5>
                    <p class="text-muted">Sistema de Gestión de Denuncias</p>
                </div>
                <div class="col-md-6 text-right">
                    <p class="text-muted mb-0">
                        © 2024 Fiscalía Chamical. Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    
    <script>
        // Form validation and enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const dniInput = document.getElementById('dni');
            
            // Format DNI input
            dniInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 8) {
                    value = value.slice(0, 8);
                }
                e.target.value = value;
            });
            
            // Form submission with loading state
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('.btn-search');
                const originalText = submitBtn.innerHTML;
                
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Consultando...';
                submitBtn.disabled = true;
                
                // Re-enable after a delay (in case of errors)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
            });
        });
    </script>
    
    <!-- Navbar Script -->
    <script src="js/new-navbar.js"></script>
</body>
</html>