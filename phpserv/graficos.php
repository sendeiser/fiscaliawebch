<?php
include('connect.php');

date_default_timezone_set("America/Argentina/Buenos_Aires");
setlocale(LC_TIME, 'es_RA.UTF-8','esp');
session_start();

$user = $_SESSION['nombre_usuario'];
$fecha = date("Y-m-d"); // Genera la fecha actual en formato "YYYY-MM-DD"
$hora = date("H:i:s"); // Genera la hora actual en formato "HH:MM:SS"




$año = $_POST['anio'];

$sql = "SELECT causa
			from expedientes WHERE LOCATE('$año', fechadeentrada) > 0";
$result = mysqli_query($conexion, $sql);

$sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario)
    VALUES ('Ninguna', 'Se genero un informe', '$fecha', '$hora', '$user')";

$conexion->query($sqlreg);


$i = 0;
while ($ver = mysqli_fetch_row($result)) {
    $valoresY[] = $i++;
    $valoresX[] = $ver[0];
}

$datosY = json_encode($valoresY);
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
    @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap');

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
        font-family: 'Fredoka One', cursive;
        text-align: center;
        text-decoration: underline;
        text-transform: uppercase;
        text-shadow: 3px 3px 5px black;
        ;
    }

    body .container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .grafica {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
    }

    #pdf_grafico {
        border-radius: 5px;
        background-color: greenyellow;
        color: #000;
        box-shadow: 2px 2px 4px #fff;
        margin-top: 1rem;
    }

    #pdf_grafico:active {
        color: #fff;
        box-shadow: 2px 2px 4px #000;
        background-color: blue;
    }
</style>

<body>
    <h1 class="title">Graficas de causas del año <?php echo $año ?></h1>
    <div id='container_grafica' class="container">
        <div id="grafica"></div>

    </div>

    <button id='pdf_grafico'>Exportar en PDF</button>

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
        datosY = crearCadenaLineal('<?php echo $datosY ?>');

        var trace1 = {
            type: 'bar',
            x: datosX,
            y: datosY,
            marker: {
                color: '#09dd39',
                line: {
                    width: 2.5
                }
            }
        };
        var data = [trace1];
        var layout = {

            title: 'Causas del Año <?php echo $año ?>',

            font: {
                size: 18
            },
            xaxis: {
                tickangle: -90
            },
            yaxis: {
                zeroline: false,
                gridwidth: 2
            },
            bargap: 0.05

        }
        var config = {
            responsive: true
        }


        Plotly.newPlot('grafica', data, layout, config);
    </script>
    <!-- WEB A PDF -->
    <script>
        const export_pdf = document.getElementById('pdf_grafico');

        export_pdf.addEventListener('click', (e) => {
            e.preventDefault();
            const $elementoParaConvertir = document.getElementById('container_grafica'); // <-- Aquí puedes elegir cualquier elemento del DOM
            html2pdf().set({
                    margin: 1,
                    filename: 'documento.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 3, // A mayor escala, mejores gráficos, pero más peso
                        letterRendering: true,
                    },
                    jsPDF: {
                        unit: "in",
                        format: "a4",
                        orientation: 'portrait' // landscape o portrait
                    }
                })
                .from($elementoParaConvertir)
                .save()
                .catch(err => console.log(err));

        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>


</html>