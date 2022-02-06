<?php
include_once 'conexion.php';
class Laboratorio{
    var $laboratorios;
    public function __construct(){
        $this->acceso = Conexion::conectar();
    }
    function mostrar(){
        $sql="SELECT * FROM expedientes";
        $resultado = $this->acceso->query($sql);
        $this->laboratorios = $resultado->fetch_all(MYSQLI_ASSOC);
        return $this->laboratorios;
    }
    function editar($id,$causa,$medida,$fechadeentrada,$fechadesalida,$comisaria,$nroexpediente,$librodeactas,$fojas,$denunciado){
        $sql="UPDATE expedientes SET causa='$causa', medida='$medida', fechadeentrada='$fechadeentrada', fojas='$fojas', librodeactas='$librodeactas', codigocomisaria='$comisaria', numerodeexpediente='$nroexpediente',denunciado='$denunciado',fechadesalida='$fechadesalida' where idexpediente='$id'";
        if($this->acceso->query($sql) === true){
            echo 'EXITOSO';
             }
             else{ 
           die ("Error al insertar datos: " . $this->acceso->error." ".$id);
              }
    }
    function eliminar($id){
        $sql="DELETE FROM expedientes where idexpediente='$id'";
        if($this->acceso->query($sql) === true){
        echo 'EXITOSO';
         }
         else{ 
       die ("Error al insertar datos: " . $this->acceso->error);
          }
    }
    function eliminarper($id){
        $sql="DELETE FROM personas1 where dnidenunciante='$id'";
        if($this->acceso->query($sql) === true){
        echo 'EXITOSO';
         }
         else{ 
       die ("Error al insertar datos: " . $this->acceso->error);
          }
    }
    function editarper($dni,$nombre,$apellido){
        $sql="UPDATE personas1 SET dnidenunciante='$dni',nombre='$nombre',apellido='$apellido' where dnidenunciante='$dni'";
        if($this->acceso->query($sql) === true){
            echo 'EXITOSO';
             }
             else{ 
           die ("Error al insertar datos: " . $this->acceso->error." ".$dni);
              }
    }

    function eliminarcomi($id){
        $sql="DELETE FROM comisarias where codigocomisaria='$id'";
        if($this->acceso->query($sql) === true){
        echo 'EXITOSO';
         }
         else{ 
       die ("Error al insertar datos: " . $this->acceso->error);
          }
    }
    function editarcomi($id,$nombre,$telefono){
        $sql="UPDATE comisarias SET descripcion='$nombre',nrodetelefono='$telefono' where codigocomisaria='$id'";
        if($this->acceso->query($sql) === true){
            echo 'EXITOSO';
             }
             else{ 
           die ("Error al insertar datos: " . $this->acceso->error." ".$id);
              }
    }
    function newcomi($nombre_comi,$nro_comi,$id_comi){
        $sql="INSERT INTO comisarias (descripcion, nrodetelefono,codigocomisaria) VALUES ('$nombre_comi','$nro_comi','$id_comi')";
        if($this->acceso->query($sql) === true){
            echo 'EXITOSO';
             }
             else{ 
           die ("Error al insertar datos: " . $this->acceso->error);
              }
    }

}