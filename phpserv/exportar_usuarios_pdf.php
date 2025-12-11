<?php
/**
 * exportar_usuarios_pdf.php
 * Exporta la lista de usuarios a formato PDF
 */

// Iniciar sesión
session_start();

// Verificar permisos de administrador de forma consistente
$rolSesion = isset($_SESSION['rol']) ? strtolower(trim($_SESSION['rol'])) : null;
$tipoSesion = isset($_SESSION['tipo']) ? strtolower(trim($_SESSION['tipo'])) : null;
if ($rolSesion !== 'administrador' && $tipoSesion !== 'admin') {
    header('Content-Type: text/plain');
    echo 'Acceso denegado. Se requiere rol de administrador.';
    exit;
}

// Incluir archivo de conexión a la base de datos
require_once 'connect.php';

// Verificar si TCPDF está disponible (debe estar instalado)
if (!file_exists('../vendor/tecnickcom/tcpdf/tcpdf.php')) {
    // Si no está disponible, crear un PDF básico con FPDF (incluido en PHP)
    require_once 'informes/fpdf.php';
    
    try {
        // Consultar todos los usuarios
        $query = "SELECT idusuarios, usuario, Nombre, Apellido, Correo, 
                  rol, intentos_fallidos, bloqueado, fecha_bloqueo 
                  FROM usuarios 
                  ORDER BY bloqueado DESC, Apellido ASC, Nombre ASC";
        
        $result = $conexion->query($query);
        
        if (!$result) {
            throw new Exception("Error en la consulta: " . $conexion->error);
        }
        
        // Crear PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // Título
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Reporte de Usuarios', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Fecha: ' . date('Y-m-d'), 0, 1, 'C');
        $pdf->Ln(10);
        
        // Encabezados de tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 7, 'ID', 1);
        $pdf->Cell(30, 7, 'Usuario', 1);
        $pdf->Cell(30, 7, 'Nombre', 1);
        $pdf->Cell(30, 7, 'Apellido', 1);
        $pdf->Cell(20, 7, 'Rol', 1);
        $pdf->Cell(20, 7, 'Intentos', 1);
        $pdf->Cell(25, 7, 'Estado', 1);
        $pdf->Cell(30, 7, 'Fecha Bloqueo', 1);
        $pdf->Ln();
        
        // Datos
        $pdf->SetFont('Arial', '', 9);
        while ($row = $result->fetch_assoc()) {
            $estado = ($row['bloqueado'] == 1) ? 'Bloqueado' : 'Activo';
            $pdf->Cell(10, 6, $row['idusuarios'], 1);
            $pdf->Cell(30, 6, $row['usuario'], 1);
            $pdf->Cell(30, 6, $row['Nombre'], 1);
            $pdf->Cell(30, 6, $row['Apellido'], 1);
            $pdf->Cell(20, 6, $row['rol'] ?: 'usuario', 1);
            $pdf->Cell(20, 6, $row['intentos_fallidos'], 1);
            $pdf->Cell(25, 6, $estado, 1);
            $pdf->Cell(30, 6, $row['fecha_bloqueo'] ?: '-', 1);
            $pdf->Ln();
        }
        
        // Registrar en la tabla de auditoría
        $usuarioAud = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'sistema';
        $detallesAud = 'Exportación de usuarios a PDF';
        $stmtAud = $conexion->prepare("INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, detalles) VALUES ('usuarios','EXPORT',DATE(NOW()),TIME(NOW()),?,?)");
        $stmtAud->bind_param('ss', $usuarioAud, $detallesAud);
        $stmtAud->execute();
        $stmtAud->close();
        
        // Salida del PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=usuarios_' . date('Y-m-d') . '.pdf');
        $pdf->Output('D', 'usuarios_' . date('Y-m-d') . '.pdf');
        
    } catch (Exception $e) {
        // En caso de error, devolver mensaje de texto plano
        header('Content-Type: text/plain');
        echo 'Error al exportar usuarios a PDF: ' . $e->getMessage();
    }
    
} else {
    // Si TCPDF está disponible, usarlo para un PDF más avanzado
    require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');
    
    try {
        // Consultar todos los usuarios
        $query = "SELECT idusuarios, usuario, Nombre, Apellido, Correo, 
                  rol, intentos_fallidos, bloqueado, fecha_bloqueo 
                  FROM usuarios 
                  ORDER BY bloqueado DESC, Apellido ASC, Nombre ASC";
        
        $result = $conexion->query($query);
        
        if (!$result) {
            throw new Exception("Error en la consulta: " . $conexion->error);
        }
        
        // Crear nuevo documento PDF
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        
        // Configurar documento
        $pdf->SetCreator('Sistema de Gestión de Fiscalía');
        $pdf->SetAuthor('Administrador');
        $pdf->SetTitle('Reporte de Usuarios');
        $pdf->SetSubject('Listado de usuarios del sistema');
        
        // Establecer márgenes
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        
        // Establecer saltos de página automáticos
        $pdf->SetAutoPageBreak(TRUE, 15);
        
        // Añadir página
        $pdf->AddPage();
        
        // Título
        $pdf->SetFont('helvetica', 'B', 18);
        $pdf->Cell(0, 10, 'Reporte de Usuarios del Sistema', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'Fecha de generación: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Ln(10);
        
        // Colores, ancho de línea y fuente en negrita
        $pdf->SetFillColor(44, 62, 80);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(128, 128, 128);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('', 'B');
        
        // Encabezados de tabla
        $w = array(15, 30, 35, 35, 50, 20, 25, 25, 40);
        $header = array('ID', 'Usuario', 'Nombre', 'Apellido', 'Correo', 'Rol', 'Intentos', 'Estado', 'Fecha Bloqueo');
        
        // Encabezado
        for($i = 0; $i < count($header); $i++)
            $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        $pdf->Ln();
        
        // Restaurar colores y fuentes
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        
        // Datos con colores alternados
        $fill = 0;
        while($row = $result->fetch_assoc()) {
            $estado = ($row['bloqueado'] == 1) ? 'Bloqueado' : 'Activo';
            $pdf->Cell($w[0], 6, $row['idusuarios'], 'LR', 0, 'C', $fill);
            $pdf->Cell($w[1], 6, $row['usuario'], 'LR', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, $row['Nombre'], 'LR', 0, 'L', $fill);
            $pdf->Cell($w[3], 6, $row['Apellido'], 'LR', 0, 'L', $fill);
            $pdf->Cell($w[4], 6, $row['Correo'], 'LR', 0, 'L', $fill);
            $pdf->Cell($w[5], 6, $row['rol'] ?: 'usuario', 'LR', 0, 'C', $fill);
            $pdf->Cell($w[6], 6, $row['intentos_fallidos'], 'LR', 0, 'C', $fill);
            
            // Color rojo para bloqueados
            if ($row['bloqueado'] == 1) {
                $pdf->SetTextColor(255, 0, 0);
                $pdf->Cell($w[7], 6, $estado, 'LR', 0, 'C', $fill);
                $pdf->SetTextColor(0);
            } else {
                $pdf->Cell($w[7], 6, $estado, 'LR', 0, 'C', $fill);
            }
            
            $pdf->Cell($w[8], 6, $row['fecha_bloqueo'] ?: '-', 'LR', 0, 'C', $fill);
            $pdf->Ln();
            $fill=!$fill;
        }
        
        // Línea de cierre
        $pdf->Cell(array_sum($w), 0, '', 'T');
        
        // Registrar en la tabla de auditoría
        $usuarioAud = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'sistema';
        $detallesAud = 'Exportación de usuarios a PDF';
        $stmtAud = $conexion->prepare("INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, detalles) VALUES ('usuarios','EXPORT',DATE(NOW()),TIME(NOW()),?,?)");
        $stmtAud->bind_param('ss', $usuarioAud, $detallesAud);
        $stmtAud->execute();
        $stmtAud->close();
        
        // Salida del PDF
        if (function_exists('ob_get_length')) { while (ob_get_level() > 0) { ob_end_clean(); } }
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename=usuarios_' . date('Y-m-d') . '.pdf');
        $pdf->Output('usuarios_' . date('Y-m-d') . '.pdf', 'I');
        
    } catch (Exception $e) {
        // En caso de error, devolver mensaje de texto plano
        header('Content-Type: text/plain');
        echo 'Error al exportar usuarios a PDF: ' . $e->getMessage();
    }
}
