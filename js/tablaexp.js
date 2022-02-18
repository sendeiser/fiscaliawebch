$(document).ready(function () {
    var buttonCommon = {
        exportOptions: {
            columns: function (column, data, node) {
                if ((column > 0) & (column < 11)) {
                    return true;
                }
                return false;
            }
        }
    }

    datatable = $('#tablaexp').DataTable({
        "bProcessing": true,
        "bDeferRender": true,
        "bServerSide": true,
        "sAjaxSource": "serverside/serversideExpedientes.php",
        "columnDefs": [{
            "targets": -1,
            "defaultContent": `<button class="editar btn btn-success" type="button" data-toggle="modal" data-target="#editar">Editar</button>
                                    <button class="eliminar btn btn-danger" type="button" data-toggle="modal" data-target="#eliminar">Eliminar</button>`
        }],
        "language": {
            "url": "http://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        responsive: true,

        dom: 'Bfrtilp',
        buttons: {
            dom: {
                button: {
                    className: 'btn'
                }
            },
            buttons: [
                $.extend(true, {}, buttonCommon, {
                    extend: 'excelHtml5',
                    text: '',
                    titleAttr: 'Exportar a Excel',
                    html: `<i></i>`,
                    className: 'btn btn-success fas fa-file-excel'
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'pdfHtml5',
                    text: '',
                    titleAttr: 'Exportar a PDF',
                    html: `<i></i>`,
                    className: 'btn btn-danger fas fa-file-pdf',

                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'print',
                    text: '',
                    titleAttr: 'Imprimir',
                    html: `<i></i>`,
                    className: 'btn btn-info fas fa-print',
                }),
                {
                    titleAttr: 'Actualizar Tabla',
                    html: `<i></i>`,
                    className: 'btn btn-light fas fa-sync reload_exp',
                }

            ]
        }
    })
})
var data; //captura la fila, para editar o eliminar

$('#tablaexp tbody').on('click', '.editar', function () {

    data = datatable.row($(this).parents()).data();

    $("#dni").val(data[1]);
    $("#id_expediente1").val(data[0]);
    $("#denunciado").val(data[2]);
    $("#fechadeentrada").val(data[3]);
    $("#fechadesalida").val(data[4]);
    $("#causa").val(data[5]);
    $("#medida").val(data[6]);
    $("#fojas").val(data[7]);
    $("#librodeactas").val(data[8]);
    $("#comisaria").val(data[9]);
    $("#nroexpediente").val(data[10]);


})

$(document).on("click", "#si-edit", function () {
    let id = $("#id_expediente1").val();

    var denunciado = $("#denunciado").val();
    var causa = $("#causa").val();
    var medida = $("#medida").val();
    var fojas = $("#fojas").val();
    var librodeactas = $("#librodeactas").val();
    var comisaria = $("#comisaria").val();
    var nroexpediente = $("#nroexpediente").val();
    var fechadeentrada = $("#fechadeentrada").val();
    var fechadesalida = $("#fechadesalida").val();

    funcion = 'editar';
    $.post('controlador/LaboratorioController.php', {
        funcion,
        id,
        causa,
        medida,
        fechadeentrada,
        fechadesalida,
        comisaria,
        nroexpediente,
        librodeactas,
        fojas,
        denunciado
    }, (response) => {
        //alert(response);
        datatable.ajax.reload(null, false);
    })

})

$(document).on("click", ".eliminar", function (e) {

    fila = $(this);

    data = datatable.row($(this).parents()).data();
    $('#laboratorio_eliminar').html(data[0]);
    $('#id_expediente2').val(data[0]);

})

$(document).on("click", "#si-eliminar", function () {

    let id = $('#id_expediente2').val();
    funcion = 'eliminar';
    $.post('controlador/LaboratorioController.php', {
        id,
        funcion
    }, (response) => {
        datatable.row(fila.parents('tr')).remove().draw();
        //datatable.ajax.reload(null, false);       
    })

})
//boton de recarga de tabla
$(document).on("click", ".reload_exp", function () {
    datatable.ajax.reload(null, false);
})