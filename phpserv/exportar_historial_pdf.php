<?php
/**
 * exportar_historial_pdf.php
 * Exporta el historial de accesos a un archivo PDF
 */

// Iniciar sesión
session_start();

// Incluir archivo de conexión a la base de datos
require_once 'conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No autorizado'
    ]);
    exit;
}

try {
    // Crear conexión a la base de datos
    $conn = Conexion::conectar();
    
    // Construir consulta base
    $sql_base = "FROM historial_accesos h LEFT JOIN usuarios u ON h.usuario_id = u.id";
    $where_clauses = [];
    $params = [];
    
    // Aplicar filtros si existen
    // 1. Filtro por fecha desde
    if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
        $where_clauses[] = "h.fecha >= :date_from";
        $params[':date_from'] = $_GET['date_from'] . ' 00:00:00';
    }
    
    // 2. Filtro por fecha hasta
    if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
        $where_clauses[] = "h.fecha <= :date_to";
        $params[':date_to'] = $_GET['date_to'] . ' 23:59:59';
    }
    
    // 3. Filtro por estado (exitoso/fallido)
    if (isset($_GET['status']) && $_GET['status'] !== '') {
        $where_clauses[] = "h.exito = :status";
        $params[':status'] = ($_GET['status'] === 'success') ? 1 : 0;
    }
    
    // 4. Filtro por usuario
    if (isset($_GET['user']) && !empty($_GET['user'])) {
        $where_clauses[] = "(u.usuario LIKE :user OR u.nombre LIKE :user OR u.apellido LIKE :user)";
        $params[':user'] = '%' . $_GET['user'] . '%';
    }
    
    // Construir cláusula WHERE completa
    $where_sql = '';
    if (!empty($where_clauses)) {
        $where_sql = "WHERE " . implode(" AND ", $where_clauses);
    }
    
    // Consulta para obtener todos los registros (sin paginación)
    $sql = "SELECT h.id, u.usuario, h.fecha, h.ip, h.exito, h.detalles 
           $sql_base $where_sql 
           ORDER BY h.fecha DESC";
    
    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Registrar la acción en la tabla de auditoría
    $sql_audit = "INSERT INTO auditoria (usuario_id, accion, detalles, fecha) 
                 VALUES (:usuario_id, 'exportar_pdf', 'Exportación de historial de accesos a PDF', NOW())";
    $stmt_audit = $conn->prepare($sql_audit);
    $stmt_audit->bindValue(':usuario_id', $_SESSION['usuario_id'], PDO::PARAM_INT);
    $stmt_audit->execute();
    
    // Intentar usar TCPDF si está disponible, de lo contrario usar FPDF
    if (file_exists('../../vendor/tecnickcom/tcpdf/tcpdf.php')) {
        // Usar TCPDF (mejor soporte para UTF-8 y más características)
        require_once('../../vendor/tecnickcom/tcpdf/tcpdf.php');
        
        // Crear instancia de TCPDF
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8');
        
        // Configurar documento
        $pdf->SetCreator('Sistema de Control de Accesos');
        $pdf->SetAuthor('Administrador');
        $pdf->SetTitle('Historial de Accesos');
        $pdf->SetSubject('Reporte de Historial de Accesos');
        
        // Eliminar cabecera y pie de página predeterminados
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // Establecer márgenes
        $pdf->SetMargins(10, 10, 10);
        
        // Establecer saltos de página automáticos
        $pdf->SetAutoPageBreak(true, 15);
        
        // Agregar página
        $pdf->AddPage();
        
        // Establecer fuente
        $pdf->SetFont('helvetica', 'B', 16);
        
        // Título
        $pdf->Cell(0, 10, 'Historial de Accesos al Sistema', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Fecha de generación: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        
        // Filtros aplicados
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 7, 'Filtros aplicados:', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        
        $filtros_texto = [];
        if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
            $filtros_texto[] = 'Desde: ' . $_GET['date_from'];
        }
        if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
            $filtros_texto[] = 'Hasta: ' . $_GET['date_to'];
        }
        if (isset($_GET['status']) && $_GET['status'] !== '') {
            $filtros_texto[] = 'Estado: ' . (($_GET['status'] === 'success') ? 'Exitoso' : 'Fallido');
        }
        if (isset($_GET['user']) && !empty($_GET['user'])) {
            $filtros_texto[] = 'Usuario: ' . $_GET['user'];
        }
        
        if (empty($filtros_texto)) {
            $pdf->Cell(0, 7, 'Sin filtros', 0, 1, 'L');
        } else {
            $pdf->Cell(0, 7, implode(' | ', $filtros_texto), 0, 1, 'L');
        }
        
        // Espacio antes de la tabla
        $pdf->Ln(5);
        
        // Cabeceras de la tabla
        $pdf->SetFillColor(220, 220, 220);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(15, 7, 'ID', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Usuario', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(35, 7, 'Dirección IP', 1, 0, 'C', true);
        $pdf->Cell(25, 7, 'Estado', 1, 0, 'C', true);
        $pdf->Cell(110, 7, 'Detalles', 1, 1, 'C', true);
        
        // Datos de la tabla
        $pdf->SetFont('helvetica', '', 9);
        $fill = false;
        
        foreach ($registros as $registro) {
            $estado = ($registro['exito'] == 1) ? 'Exitoso' : 'Fallido';
            $pdf->Cell(15, 6, $registro['id'], 1, 0, 'C', $fill);
            $pdf->Cell(40, 6, $registro['usuario'] ?: 'N/A', 1, 0, 'L', $fill);
            $pdf->Cell(40, 6, $registro['fecha'], 1, 0, 'C', $fill);
            $pdf->Cell(35, 6, $registro['ip'], 1, 0, 'C', $fill);
            $pdf->Cell(25, 6, $estado, 1, 0, 'C', $fill);
            $pdf->Cell(110, 6, $registro['detalles'] ?: '-', 1, 1, 'L', $fill);
            $fill = !$fill; // Alternar colores
        }
        
        // Pie de página
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'I', 8);
        $pdf->Cell(0, 5, 'Este documento es confidencial y contiene información de accesos al sistema.', 0, 1, 'C');
        
    } else {
        // Usar FPDF (alternativa más simple)
        require_once('fpdf/fpdf.php');
        
        // Crear instancia de FPDF
        $pdf = new FPDF('L', 'mm', 'A4');
        
        // Agregar página
        $pdf->AddPage();
        
        // Establecer fuente
        $pdf->SetFont('Arial', 'B', 16);
        
        // Título
        $pdf->Cell(0, 10, utf8_decode('Historial de Accesos al Sistema'), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, 'Fecha de generacion: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        
        // Filtros aplicados
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 7, 'Filtros aplicados:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        
        $filtros_texto = [];
        if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
            $filtros_texto[] = 'Desde: ' . $_GET['date_from'];
        }
        if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
            $filtros_texto[] = 'Hasta: ' . $_GET['date_to'];
        }
        if (isset($_GET['status']) && $_GET['status'] !== '') {
            $filtros_texto[] = 'Estado: ' . (($_GET['status'] === 'success') ? 'Exitoso' : 'Fallido');
        }
        if (isset($_GET['user']) && !empty($_GET['user'])) {
            $filtros_texto[] = 'Usuario: ' . $_GET['user'];
        }
        
        if (empty($filtros_texto)) {
            $pdf->Cell(0, 7, 'Sin filtros', 0, 1, 'L');
        } else {
            $pdf->Cell(0, 7, utf8_decode(implode(' | ', $filtros_texto)), 0, 1, 'L');
        }
        
        // Espacio antes de la tabla
        $pdf->Ln(5);
        
        // Cabeceras de la tabla
        $pdf->SetFillColor(220, 220, 220);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 7, 'ID', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Usuario', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(35, 7, utf8_decode('Dirección IP'), 1, 0, 'C', true);
        $pdf->Cell(25, 7, 'Estado', 1, 0, 'C', true);
        $pdf->Cell(110, 7, 'Detalles', 1, 1, 'C', true);
        
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 9);
        $fill = false;
        
        foreach ($registros as $registro) {
            $estado = ($registro['exito'] == 1) ? 'Exitoso' : 'Fallido';
            $pdf->Cell(15, 6, $registro['id'], 1, 0, 'C', $fill);
            $pdf->Cell(40, 6, utf8_decode($registro['usuario'] ?: 'N/A'), 1, 0, 'L', $fill);
            $pdf->Cell(40, 6, $registro['fecha'], 1, 0, 'C', $fill);
            $pdf->Cell(35, 6, $registro['ip'], 1, 0, 'C', $fill);
            $pdf->Cell(25, 6, utf8_decode($estado), 1, 0, 'C', $fill);
            $pdf->Cell(110, 6, utf8_decode($registro['detalles'] ?: '-'), 1, 1, 'L', $fill);
            $fill = !$fill; // Alternar colores
        }
        
        // Pie de página
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 5, utf8_decode('Este documento es confidencial y contiene información de accesos al sistema.'), 0, 1, 'C');
    }
    
    // Configurar cabeceras para descarga de PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename=historial_accesos_' . date('Y-m-d') . '.pdf');
    
    // Enviar PDF al navegador
    $pdf->Output('historial_accesos_' . date('Y-m-d') . '.pdf', 'D');
    
} catch (Exception $e) {
    // Registrar error en log del servidor
    error_log("Error en exportar_historial_pdf.php: " . $e->getMessage());
    
    // Devolver mensaje de error
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al generar PDF: ' . $e->getMessage()
    ]);
} finally {
    // Cerrar conexión
    $conn = null;
}

// No es necesario devolver nada más, el archivo PDF ya se ha enviado
exit;