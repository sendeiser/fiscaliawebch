<?php
include_once 'conexion.php';
date_default_timezone_set("America/Argentina/Buenos_Aires");
setlocale(LC_TIME, 'es_RA.UTF-8', 'esp');
/* include_once '../phpserv/connect.php';  */
session_start();

class Laboratorio
{

    var $laboratorios;
    private $acceso;
    private $user;
    private $fecha;
    private $hora;
    public function __construct()
    {

        $this->acceso = Conexion::conectar();
        $this->user = $_SESSION['nombre_usuario'];
        $this->fecha = date("Y-m-d"); // Genera la fecha actual en formato "YYYY-MM-DD"
        $this->hora = date("H:i:s"); // Genera la hora actual en formato "HH:MM:SS"
    }
    function mostrar()
    {
        $sql = "SELECT * FROM expedientes";
        $resultado = $this->acceso->query($sql);
        $this->laboratorios = $resultado->fetch_all(MYSQLI_ASSOC);
        return $this->laboratorios;
    }
    function editar($id, $causa, $medida, $fechadeentrada, $fechadesalida, $comisaria, $nroexpediente, $librodeactas, $fojas, $denunciado)
    {
        $sql = "UPDATE expedientes SET causa='$causa', medida='$medida', fechadeentrada='$fechadeentrada', fojas='$fojas', librodeactas='$librodeactas', codigocomisaria='$comisaria', numerodeexpediente='$nroexpediente',denunciado='$denunciado',fechadesalida='$fechadesalida' where idexpediente='$id'";


        $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente)
VALUES ('expedientes', 'Se edito un expediente', '$this->fecha', '$this->hora', '$this->user', '$nroexpediente')";


        if ($this->acceso->query($sql) === true) {
            if ($this->acceso->query($sqlreg) === true) {
                echo 'EXITOSO';
            } else {
                die("Error al insertar datos en registroseg: " . $this->acceso->error);
            }
        } else {
            die("Error al insertar datos: " . $this->acceso->error . " " . $id);
        }
    }
    function eliminar($id, $nroexpediente)
    {
        $sql = "DELETE FROM expedientes where idexpediente='$id'";

        $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente)
VALUES ('expedientes', 'Se elimino un expediente', '$this->fecha', '$this->hora', '$this->user', '$nroexpediente')";



        if ($this->acceso->query($sql) === true) {
            if ($this->acceso->query($sqlreg) === true) {
                echo 'EXITOSO';
            } else {
                die("Error al insertar datos en auditoria: " . $this->acceso->error);
            }
        } else {
            die("Error al insertar datos: " . $this->acceso->error);
        }
    }
    function eliminarper($id)
    {
        $sql = "DELETE FROM personas1 where dnidenunciante='$id'";
        $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente, dni)
VALUES ('personas', 'Se elimino una persona', '$this->fecha', '$this->hora', '$this->user', NULL,'$id')";

        if ($this->acceso->query($sql) === true) {
            if ($this->acceso->query($sqlreg) === true) {
                echo 'EXITOSO';
            } else {
                die("Error al insertar datos en auditoria: " . $this->acceso->error);
            }
        } else {
            die("Error al insertar datos: " . $this->acceso->error);
        }
    }
    function editarper($dni, $nombre, $apellido)
    {
        $sql = "UPDATE personas1 SET dnidenunciante='$dni',nombre='$nombre',apellido='$apellido' where dnidenunciante='$dni'";
        $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente, dni)
VALUES ('personas', 'Se edito una persona', '$this->fecha', '$this->hora', '$this->user', NULL,'$dni')";

        if ($this->acceso->query($sql) === true) {
            if ($this->acceso->query($sqlreg) === true) {
                echo 'EXITOSO';
            } else {
                die("Error al insertar datos en auditoria: " . $this->acceso->error);
            }
        } else {
            die("Error al insertar datos: " . $this->acceso->error . " " . $dni);
        }
    }

    function eliminarcomi($id)
    {
        $sql = "DELETE FROM comisarias where codigocomisaria='$id'";

        $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente, dni)
VALUES ('comisarias', 'Se elimino una comisaria', '$this->fecha', '$this->hora', '$this->user', NULL,'$id')";

        if ($this->acceso->query($sql) === true) {
            if ($this->acceso->query($sqlreg) === true) {
                echo 'EXITOSO';
            } else {
                die("Error al insertar datos en auditoria: " . $this->acceso->error);
            }
        } else {
            die("Error al insertar datos: " . $this->acceso->error);
        }
    }
    function editarcomi($id, $nombre, $telefono)
    {
        $sql = "UPDATE comisarias SET descripcion='$nombre',nrodetelefono='$telefono' where codigocomisaria='$id'";
        $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente, dni)
VALUES ('comisarias', 'Se edito una comisaria', '$this->fecha', '$this->hora', '$this->user', NULL,'$id')";

        if ($this->acceso->query($sql) === true) {
            if ($this->acceso->query($sqlreg) === true) {
                echo 'EXITOSO';
            } else {
                die("Error al insertar datos en auditoria: " . $this->acceso->error);
            }
        } else {
            die("Error al insertar datos: " . $this->acceso->error . " " . $id);
        }
    }
    function newcomi($nombre_comi, $nro_comi, $id_comi)
    {
        $sql = "INSERT INTO comisarias (descripcion, nrodetelefono,codigocomisaria) VALUES ('$nombre_comi','$nro_comi','$id_comi')";
        if ($this->acceso->query($sql) === true) {
            echo 'EXITOSO';
        } else {
            die("Error al insertar datos: " . $this->acceso->error);
        }
    }
}
