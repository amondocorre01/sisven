window.angularApp.controller("CobrosController", [
    "$scope",
    "API_URL",
    "window",
    "jQuery",
    "$http",
    "ProductViewModal",
    "ProductEditModal",
    "ProductDeleteModal",
    "ProductReturnModal",
    "CategoryCreateModal",
    "SupplierCreateModal",
    "BrandCreateModal",
    "BoxCreateModal",
    "UnitCreateModal",
    "TaxrateCreateModal",
    "POSFilemanagerModal",
    "EmailModal",
function (
    $scope,
    API_URL,
    window,
    $,
    $http,
    ProductViewModal,
    ProductEditModal,
    ProductDeleteModal,
    ProductReturnModal,
    CategoryCreateModal,
    SupplierCreateModal,
    BrandCreateModal,
    BoxCreateModal,
    UnitCreateModal,
    TaxrateCreateModal,
    POSFilemanagerModal,
    EmailModal
) {
    "use strict";

    var dt = $("#cobros-list");
    var supplierId;
    var productId;
    var productLocation;

    var printColumns = dt.data("print-columns");
    var i;
    var hideColums = dt.data("hide-colums").split(",");
    var hideColumsArray = [];
    if (hideColums.length) {
        for (i = 0; i < hideColums.length; i+=1) {     
           hideColumsArray.push(parseInt(hideColums[i]));
        }
    }

    supplierId = window.getParameterByName("sup_id");
    productLocation = window.getParameterByName("location");
    console.log('iddd',supplierId);
    console.log('proddd',productLocation);

    //================
    // Start datatable
    //================

    dt.dataTable({
        "oLanguage": {sProcessing: "<img src='../assets/itsolution24/img/loading2.gif'>"},
        "processing": true,
        "dom": "lfBrtip",
        "serverSide": true,
        "ajax": API_URL + "/_inc/cobros.php?sup_id=" + supplierId + "&location=" + productLocation,
        "order": [[ 2, "desc"]],
        "aLengthMenu": [
            [10, 25, 50, 100, 200, -1],
            [10, 25, 50, 100, 200, "All"]
        ],
        "columnDefs": [
            {"targets": [0, 1, 2, 3, 4, 6], "orderable": false},
            {"className": "text-center", "targets": [0, 1, 3, 4, 6]},
            {"className": "text-right", "targets": [2, 5]},
            {"visible": false, "targets": hideColumsArray},
            { 
                "targets": [1],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#cobros-list thead tr th:eq(1)").html());
                }
            },
            { 
                "targets": [2],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#cobros-list thead tr th:eq(2)").html());
                }
            },
            { 
                "targets": [3],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#cobros-list thead tr th:eq(3)").html());
                }
            },
            { 
                "targets": [4],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#cobros-list thead tr th:eq(4)").html());
                }
            },
            { 
                "targets": [5],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#cobros-list thead tr th:eq(5)").html());
                }
            },
            { 
                "targets": [6],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#cobros-list thead tr th:eq(6)").html());
                }
            },
        ],
        "aoColumns": [
            {data: "select"},
            {data: "nombre_cobro"},
            {data: "monto_cobro"},
            {data: "fecha_cobro"},
            {data: "notas_venta_cobro"},
            {data: "proximo_pago_cobro"},
            {data: "delete_btn"}
        ],
        "pageLength": window.settings.datatable_item_limit,
        "buttons": [
            {
                extend:    "print",footer: 'true',
                text:      "<i class=\"fa fa-print\"></i>",
                titleAttr: "Print",
                title: "Product List",
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .append(
                            '<div><b><i>Powered by:  </i></b></div>'
                        )
                        .prepend(
                            '<div class="dt-print-heading"><img class="logo" src="'+window.logo+'"/><h2 class="title">'+window.store.name+'</h2><p>Printed on: '+window.formatDate(new Date())+'</p></div>'
                        );
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                },
                exportOptions: {
                    columns: [printColumns]
                }
            },
            {
                extend:    "copyHtml5",
                text:      "<i class=\"fa fa-files-o\"></i>",
                titleAttr: "Copy",
                title: window.store.name + " > Products",
                exportOptions: {
                    columns: [printColumns]
                }
            },
            {
                extend:    "excelHtml5",
                text:      "<i class=\"fa fa-file-excel-o\"></i>",
                titleAttr: "Excel",
                title: window.store.name + " > Products",
                exportOptions: {
                    columns: [printColumns]
                }
            },
            {
                extend:    "csvHtml5",
                text:      "<i class=\"fa fa-file-text-o\"></i>",
                titleAttr: "CSV",
                title: window.store.name + " > Products",
                exportOptions: {
                    columns: [printColumns]
                }
            },
            {
                extend:    "pdfHtml5",
                text:      "<i class=\"fa fa-file-pdf-o\"></i>",
                titleAttr: "PDF",
                download: "open",
                title: window.store.name + " > Products",
                exportOptions: {
                    columns: [printColumns]
                },
                customize: function (doc) {
                    doc.content[1].table.widths =  Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    doc.pageMargins = [10,10,10,10];
                    doc.defaultStyle.fontSize = 7;
                    doc.styles.tableHeader.fontSize = 7;
                    doc.styles.title.fontSize = 9;
                    // Remove spaces around page title
                    doc.content[0].text = doc.content[0].text.trim();
                    // Header
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        fontSize: 8,
                        text: 'Printed on: '+window.formatDate(new Date()),
                    });
                    // Create a footer
                    doc['footer']=(function(page, pages) {
                        return {
                            columns: [
                                'Powered by  ',
                                {
                                    // This is the right column
                                    alignment: 'right',
                                    text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                                }
                            ],
                            margin: [10, 0]
                        };
                    });
                    // Styling the table: create style object
                    var objLayout = {};
                    // Horizontal line thickness
                    objLayout['hLineWidth'] = function(i) { return 0.5; };
                    // Vertikal line thickness
                    objLayout['vLineWidth'] = function(i) { return 0.5; };
                    // Horizontal line color
                    objLayout['hLineColor'] = function(i) { return '#aaa'; };
                    // Vertical line color
                    objLayout['vLineColor'] = function(i) { return '#aaa'; };
                    // Left padding of the cell
                    objLayout['paddingLeft'] = function(i) { return 4; };
                    // Right padding of the cell
                    objLayout['paddingRight'] = function(i) { return 4; };
                    // Inject the object in the document
                    doc.content[1].layout = objLayout;
                }
            }
        ]
    });

    //Create cobros
    // Create product
    $(document).delegate("#cobros-submit", "click", function(e) {
        e.preventDefault();
        let nombre = $('#nombre').val();
        let monto = $('#monto').val();
        let fecha = $('#fecha').val();
        let nota_venta = $('#nota_venta').val();
        let proximo_pago = $('#proximo_pago').val();
        if(nombre.trim() != '' && monto.trim() != '' && fecha.trim() != '' && nota_venta != '' && proximo_pago != ''){

        }else{
            alert('error en el formulario');
            return;
        }
        var $tag = $(this);
        var $btn = $tag.button("loading");
        var form = $($tag.data("form"));
        form.find(".alert").remove();
        var actionUrl = form.attr("action");
        
        $http({
            url: window.baseUrl + "/_inc/" + actionUrl,
            method: "POST",
            data: form.serialize(),
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {
            
            $btn.button("reset");
            $(":input[type=\"button\"]").prop("disabled", false);
            var alertMsg = response.data.msg;
            window.toastr.success(alertMsg, "Success!");

            productId = response.data.id;
            
            dt.DataTable().ajax.reload(function(json) {
                if ($("#row_"+productId).length) {
                    $("#row_"+productId).flash("yellow", 5000);
                }
            }, false);

            setTimeout(function() {
                // Reset form
                $("#reset").trigger("click");
                $("#category_id").val(null).trigger("change");
                $("#sup_id").val(null).trigger("change");
                $("#brand_id").val(null).trigger("change");
                $("#box_id").val(null).trigger("change");
                $("#unit_id").val(null).trigger("change");
                $("#random_num").val(null).trigger("click");
                $("#p_thumb img").attr("src", "../assets/itsolution24/img/noimage.jpg");
                $("#p_image").val("");
            }, 100);


        }, function(response) {

            $btn.button("reset");
            $(":input[type=\"button\"]").prop("disabled", false);
            var alertMsg = "<div>";
            window.angular.forEach(response.data, function(value) {
                alertMsg += "<p>" + value + ".</p>";
            });
            alertMsg += "</div>";
            window.toastr.warning(alertMsg, "Warning!");
        });
    });

}]);