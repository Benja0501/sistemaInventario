// public/assets/js/purchase.js

$(document).ready(function () {
    $("#purchases-table").DataTable({
        dom:
            "<'row mb-3'<'col-sm-4'l><'col-sm-4'f><'col-sm-4 text-right'B>>" +
            "<'row'<'col-sm-12 table-responsive'tr>>" +
            "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"],
        ],
        buttons: [
            {
                extend: "copy",
                text: '<i class="far fa-copy"></i> Copiar',
                className: "btn btn-sm btn-outline-secondary",
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: "btn btn-sm btn-outline-success",
            },
            {
                extend: "pdf",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: "btn btn-sm btn-outline-danger",
            },
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: "btn btn-sm btn-outline-info",
            },
        ],
        responsive: true,
        columnDefs: [
            { orderable: false, targets: -1 },
            { className: "text-center", targets: -1 },
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        },
    });
});
