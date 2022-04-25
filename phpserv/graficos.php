<?php
include('connect.php');

$año = $_POST['anio'];

$sql = "SELECT causa 
			from expedientes WHERE LOCATE('$año', fechadesalida) > 0";
$result = mysqli_query($conexion, $sql);

   
    while ($ver = mysqli_fetch_row($result)) {
       /*  $valoresY[] = $ver[1]; */
        $valoresX[] = $ver[0];
    }
    
    /* $datosY = json_encode($valoresY); */
    $datosX = json_encode($valoresX);


?>
<!DOCTYPE html>
<html>

<head>
    <title>Graficos</title>
    <link rel="stylesheet" type="text/css" href="../lib/bootstrap.css">
    <script src="../lib/jquery-3.3.1.min.js"></script>
    <script src="../lib/plotly-latest.min.js"></script>
</head>
<style>
    body {
        width: 100%;
        min-height: 100vh;
        background: url('../images/madera1.jpg') center/100% 100% no-repeat;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    body .title {
        margin: 2.4rem 0;
        color: #fff;
        font-size: 2.3rem;
        font-family: 'Poppins', sans-serif;
        text-align: center;
        text-decoration: underline;
        text-transform: uppercase;
    }

    body .container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .grafica {
        width: 100%;
        display: flex;
    }
</style>

<body>
    <h1 class="title">Graficos</h1>
    <div class="container">
        <div id="grafica"></div>

    </div>


    <script type="text/javascript">
        function crearCadenaLineal(json) {
            var parsed = JSON.parse(json);
            var arr = [];
            for (var x in parsed) {
                arr.push(parsed[x]);
            }
            return arr;
        }
    </script>
    <script type="text/javascript">
        datosX = crearCadenaLineal('<?php echo $datosX ?>');

        var data = [{
            labels: datosX,
            /* y: datosY, */
            type: 'pie'
        }];
        var layout = {

            height: 400,
            width: 500

        };

        Plotly.newPlot('grafica', data, layout);
    </script>
</body>

</html>