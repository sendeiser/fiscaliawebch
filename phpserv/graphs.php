<?php
include('connect.php');

$causa = $_POST['causas'];

$sql = "SELECT '$causa',fechadeentrada 
			from expedientes ORDER BY fechadeentrada DESC";
$result = mysqli_query($conexion, $sql);


while ($ver = mysqli_fetch_row($result)) {
    $valoresY[] = $ver[1];
    $valoresX[] = $ver[0];
}

$datosY = json_encode($valoresY);
$datosX = json_encode($valoresX);

?>

<div id="graficaLineal"></div>

<script type="text/javascript">
	function crearCadenaLineal(json){
		var parsed = JSON.parse(json);
		var arr = [];
		for(var x in parsed){
			arr.push(parsed[x]);
		}
		return arr;
	}
</script>