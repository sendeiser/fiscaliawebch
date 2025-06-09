
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="css/theme.css">
    <script src="js/theme.js"></script>
    <title>Auditoría</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="transition-colors duration-200 bg-white dark:bg-zinc-700">
    <button id="theme-toggle" class="theme-toggle">
        <svg class="w-6 h-6 text-yellow-300 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    </button>
    <div class="bg-zinc-100 dark:bg-zinc-800 p-4">
        <h1 class="text-center text-5xl font-bold text-slate-500 mb-6">Auditoria</h1>
        <!-- Modificar los botones existentes -->
        <div class="flex justify-between mb-2">
            <button onclick="exportToPDF()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Exportar en PDF
            </button>
            <button onclick="exportToExcel()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Exportar en Excel
            </button>
        </div>
        <input class="mb-2" type="text" id="search" placeholder="Buscar...">
        <div class="overflow-x-auto">
            <table id="mytable" class="table-auto w-full">
                <thead class="text-xs font-semibold uppercase text-zinc-400 bg-zinc-50 dark:bg-zinc-700 dark:text-zinc-400">
                    <tr>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Tabla afectada</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Operacion</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Fecha</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Hora</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Usuario</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Num.Expediente</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">DNI/ID</div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-zinc-100 dark:divide-zinc-700 text-white">

                    <?php
                    // Conexión a la base de datos MySQL
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "fiscaliach";

                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    // Consulta para obtener los datos de la tabla
                    $sql = "SELECT * FROM auditoria";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row["tabla_afectada"] . "</td><td>" . $row["operacion"] . "</td><td>" . $row["fecha"] . "</td><td>" . $row["hora"] . "</td><td>" . $row["usuario"] . "</td><td>" . $row["num_expediente"] . "</td><td>" . $row["dni"] . "</td></tr>";
                            echo "";
                            echo "";
                            echo "";
                            echo "";
                            echo "";
                            echo "";
                            echo "";
                            echo "";
                        }
                    } else {
                        echo "No se encontraron registros.";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $("#search").keyup(function() {
                const searchText = $(this).val().toLowerCase();
                $("#mytable tbody tr").each(function() {
                    const rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });

            // Agregar la funcionalidad del tema aquí
            if (localStorage.getItem('theme') === 'dark' ||
                (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }

            // Evento de clic para el botón de tema
            document.getElementById('theme-toggle').addEventListener('click', function() {
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme',
                    document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                );
            });
        });

        // Funciones de exportación existentes
        function exportToPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Agregar título
            doc.setFontSize(18);
            doc.text('Reporte de Auditoría', 14, 20);

            // Obtener datos de la tabla
            const table = document.querySelector('table');
            doc.autoTable({
                html: table,
                startY: 30,
                styles: {
                    fontSize: 8,
                    cellPadding: 2,
                },
                headStyles: {
                    fillColor: [45, 45, 45],
                    textColor: 255,
                    fontSize: 9
                }
            });

            doc.save('auditoria.pdf');
        }

        function exportToExcel() {
            const table = document.querySelector('table');
            const wb = XLSX.utils.table_to_book(table, {
                sheet: "Auditoría"
            });
            XLSX.writeFile(wb, 'auditoria.xlsx');
        }
    </script>
<!-- Al final del body, antes del cierre, un solo bloque de script -->
<script>
    $(document).ready(function() {
        // Búsqueda
        $("#search").keyup(function() {
            const searchText = $(this).val().toLowerCase();
            $("#mytable tbody tr").each(function() {
                const rowText = $(this).text().toLowerCase();
                $(this).toggle(rowText.indexOf(searchText) > -1);
            });
        });
    });

    // Funciones de exportación
    function exportToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.setFontSize(18);
        doc.text('Reporte de Auditoría', 14, 20);
        
        const table = document.querySelector('table');
        doc.autoTable({
            html: table,
            startY: 30,
            styles: { fontSize: 8, cellPadding: 2 },
            headStyles: { fillColor: [45, 45, 45], textColor: 255, fontSize: 9 }
        });
        
        doc.save('auditoria.pdf');
    }

    function exportToExcel() {
        const table = document.querySelector('table');
        const wb = XLSX.utils.table_to_book(table, { sheet: "Auditoría" });
        XLSX.writeFile(wb, 'auditoria.xlsx');
    }
</script>
</body>
</html>



