<?php 
ob_start();
session_start();
include ("../_init.php");

// Redirect, If user is not logged in
if (!is_loggedin()) {
  redirect(root_url() . '/index.php?redirect_to=' . url());
}

// Redirect, If User has not Read Permission
if (user_group_id() != 1 && !has_permission('access', 'read_supplier')) {
  redirect(root_url() . '/'.ADMINDIRNAME.'/dashboard.php');
}

// Set Document Title
$document->setTitle(trans('text_supplier_list_title'));

// Add Script
//$document->addScript('../assets/itsolution24/angular/controllers/SupplierProfileController.js');
//$document->addScript('../assets/itsolution24/angular/controllers/SupplierController.js');


// Include Header and Footer
include("header.php"); 
include ("left_sidebar.php"); 
?>
<link href="../assets/estilos/estilos.css" type="text/css" rel="stylesheet">

<!-- Content Wrapper Start -->
<div class="content-wrapper">

  <!-- Content Header Start -->
  <section class="content-header">
    <h1>
      REPORTE VENTAS DETALLADO
      <small>
        <?php echo store('name'); ?>
      </small>
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="dashboard.php">
          <i class="fa fa-dashboard"></i> 
          <?php echo trans('text_dashboard'); ?>
        </a>
      </li>
      <li class="active">
        REPORTE
      </li>
    </ol>
  </section>
  <!-- Content Header End -->

  <!-- Content Start -->
  <section class="content">

    <?php if(DEMO) : ?>
    <div class="box">
      <div class="box-body">
        <div class="alert alert-info mb-0">
          <p><span class="fa fa-fw fa-info-circle"></span> <?php echo $demo_text; ?></p>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
    <?php if (user_group_id() == 1 || has_permission('access', 'create_supplier')) : ?>
    <div class="box box-info<?php echo create_box_state(); ?>">
      <?php if (isset($error_message)): ?>
        <div class="alert alert-danger">
            <p>
              <span class="fa fa-warning"></span> 
              <?php echo $error_message ; ?>
            </p>
        </div>
      <?php elseif (isset($success_message)): ?>
        <div class="alert alert-success">
            <p>
              <span class="fa fa-check"></span> 
              <?php echo $success_message ; ?>
            </p>
        </div>
      <?php endif; ?>

      <!-- Add Supplier Create Form -->
      <?php include('../_inc/template/supplier_create_form.php'); ?>

    </div>
    <?php endif; ?>
    <?php

        if(isset($_POST['buscar'])){
          var_dump('Vamos a buscar por los valore dinamicos');
          //var_dump($_POST);
          //$fecha_final = set_value('fecha_final');
          //var_dump('FECHA FINAL',$fecha_final);
          //exit();
        }
        $report = getReportProducts();
        $report = json_decode(json_encode($report, JSON_FORCE_OBJECT));

        $suppliers = getSuppliers();
        $suppliers = json_decode(json_encode($suppliers, JSON_FORCE_OBJECT));

        $categories = getCategories();
        $categories = json_decode(json_encode($categories, JSON_FORCE_OBJECT));

        $customers = getCustomers();
        $customers = json_decode(json_encode($customers, JSON_FORCE_OBJECT));

        $salespersons = getUsers();
        $salespersons = json_decode(json_encode($salespersons, JSON_FORCE_OBJECT));

        $stores = getStores();
        $stores = json_decode(json_encode($stores, JSON_FORCE_OBJECT));

        $products = getProducts();
        $products = json_decode(json_encode($products, JSON_FORCE_OBJECT));


        //exit();
    ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">
              
            </h3>
            <!--<form id="form-search-report" method="POST" onsubmit="valida(this)" action="#">-->
            <div class="row">
                <div class="col-offset-1 col-md-2">
                    <label for="">Fecha Inicial</label>
                    <input type="date" name="fecha_inicial" id="fecha_inicial" autocomplete="off">
                </div>
                <div class="col-offset-1 col-md-2">
                    <label for="">Fecha Final</label>
                    <input type="date" name="fecha_final" id="fecha_final" autocomplete="off">
                </div>
            </div>
            <div class="row">
              <div class="col-offset-1 col-md-2">
                    <label for="">Cliente</label>
                    <select id="id_cliente" class="form-control select2 " name="category_id">
                        <option value="">Seleccione</option>
                        <?php foreach ($customers as $key => $value) {?>
                            <option value="<?php echo $value->customer_id; ?>"><?php echo $value->customer_name; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-offset-1 col-md-2">
                    <label for="">Vendedor</label>
                    <select id="id_vendedor" class="form-control select2 " name="category_id">
                        <option value="">Seleccione</option>
                        <?php foreach ($salespersons as $key => $value) {?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->username; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-offset-1 col-md-2">
                    <label for="">Estado</label>
                    <select id="estado_pago" class="form-control select2 " name="category_id">
                        <option value="">Seleccione</option>
                        <option value="paid">PAGADO</option>
                        <option value="due">CON DEUDA</option>
                    </select>
                </div>
                <div class="col-offset-1 col-md-2">
                    <label for="">Producto</label>
                    <select id="id_producto" class="form-control select2 " name="category_id">
                        <option value="">Seleccione</option>
                        <?php foreach ($products as $key => $value) {?>
                            <option value="<?php echo $value->p_id; ?>"><?php echo $value->p_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-offset-1 col-md-2">
                    <label for="">Almacen</label>
                    <select id="id_almacen" class="form-control select2 " name="category_id">
                        <option value="">Seleccione</option>
                        <?php foreach ($stores as $key => $value) {?>
                            <option value="<?php echo $value->store_id; ?>"><?php echo $value->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-offset-1 col-md-2">
                <label for="" class="white">.</label>
                <br>
                <input class="btn btn-primary btn-lg" onclick="buscarDatos()" type="submit" value="Buscar" name="buscar" >
                </div>
            </div>
            <!--</form>-->
          </div>
          <div class="box-body">
            <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped table-hover dataTable" style="width:100%">
                <thead>
                    <tr class="bg-gray">
                        <th>NRO</th>    
                        <th>CLIENTE</th>
                        <th>FECHA</th>
                        <th>VENDEDOR</th>
                        <th>ESTADO</th>
                        <th>TIENDA</th>
                        <th>CANTIDAD</th>
                        <th>PRECIO UNITARIO</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php /*
                        foreach ($report as $key => $value) {
                            echo "<tr>
                                    <td>$value->p_code</td>
                                    <td>$value->p_name</td>
                                    <td>$value->medida</td>
                                    <td>$value->unidad_caja</td>
                                </tr>";
                        }*/
                    ?>
                </tbody>
            </table>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Content End -->
</div>
<!-- Content Wrapper End -->

<div class="modal" id="detalleVenta" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">DETALLE DE VENTA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="detalleventa">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include ("footer.php"); ?>
<script>
    //new DataTable('#example');
    $(document).ready(function(){
    var dt= $('#example');
    dt.dataTable({
      "processing": true,
      "lengthChange": true,
      "autoWidth": false,
      "ajax": {
                url: "../_inc/report_sales_detail_table.php",
                dataSrc: "",
                data: function ( d ) {
                      d.fecha_inicial = $('#fecha_inicial').val();
                      d.fecha_final = $('#fecha_final').val();
                      d.cliente = $('#id_cliente').val();
                      d.vendedor = $('#id_vendedor').val();
                      d.estado = $('#estado_pago').val();
                      d.producto = $('#id_producto').val();
                      d.almacen = $('#id_almacen').val();
                    }
                /*data: {
                    'searchType': GetSearchType(),
                    'searchText': GetSearchText()
                }*/
               },
      "columns": [
        { "data": "invoice_id" },
        { "data": "customer_name" },
        { "data": "created_at" },
        { "data": "created_by_name" },
        { "data": "payment_status" },
        { "data": "store_name" },
        { "data": "item_quantity" },
        { "data": "item_price" },
        { "data": "item_total" },
        /*{
          sortable: false,
          "render": function ( data, type, row, meta ) {
              var buttonID = "rollover_"+row.info_id;
              return '<a id='+buttonID+' onclick="verDetalle('+row.invoice_id+')" class="btn btn-success verBtn" role="button">Ver</a>';
          }
        }*/
      ],
      //"responsive": true,
      language:{ search: "Buscar", lengthMenu: "Mostrar _MENU_", zeroRecords: "No se encontró nada",
                    info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros", infoEmpty: "No hay registros disponibles", 
                    infoFiltered: "(Filtrado de _MAX_ registros totales)", previous: "Anterior", oPaginate: { sNext:"Siguiente", sLast: "Último", sPrevious: "Anterior", sFirst:"Primero" },                  
                    }, 
        "processing": false,
        "dom": "lfBrtip",
        "serverSide": false,
        "aLengthMenu": [
            [5,10, 25, 50, 100, 200, -1],
            [5,10, 25, 50, 100, 200, "All"]
        ],
        "pageLength":5,
        "columnDefs": [
            {"targets": [0, 1, 2, 3], "orderable": true},
            {"className": "text-center", "targets": [ 3]},
            {"className": "text-left", "targets": [0,1,2]}
        ],
        "buttons": [
            {
                extend:    "print",footer: 'true',
                text:      "<i class=\"fa fa-print\"></i>",
                titleAttr: "Imprimir",
                title: "Lista",
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .append(
                            '<div><b><i>Powered by:  </i></b></div>'
                        )
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
            },
            {
                extend:    "copyHtml5",
                text:      "<i class=\"fa fa-files-o\"></i>",
                titleAttr: "Copiar",
                title: '',
                //title: window.store.name + " > Products",
            },
            {
                extend:    "excelHtml5",
                text:      "<i class=\"fa fa-file-excel-o\"></i>",
                titleAttr: "Excel",
                title: '',
                //title: window.store.name + " > Products",
            },
            {
                extend:    "csvHtml5",
                text:      "<i class=\"fa fa-file-text-o\"></i>",
                titleAttr: "CSV",
                title: '',
                //title: window.store.name + " > Products",
            },
            {
                extend:    "pdfHtml5",
                text:      "<i class=\"fa fa-file-pdf-o\"></i>",
                titleAttr: "PDF",
                download: "open",
                title: '-',
                //title: window.store.name + " > Products",
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
                        text: 'Impreso : '+window.formatDate(new Date()),
                    });
                    // Create a footer
                    doc['footer']=(function(page, pages) {
                        return {
                            columns: [
                                ' ',
                                {
                                    // This is the right column
                                    alignment: 'right',
                                    text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                                }
                            ],
                            margin: [10, 0]
                        };
                    });
                }
            }
        ]
    });


});

function valida(e){
  console.log('Validando el formulario');
  return false;
}

function buscarDatos(){
  var dt= $('#example');
  $(dt).DataTable().ajax.reload(null, false);
}

function verDetalle(id){
  $('#detalleventa').empty();
  $.post('../_inc/report_sales_detail.php', {invoice_id:id})
    .done(function (data) {
      console.log(data);
      html = '<table class="table table-head-fixed text-nowrap">';
      html += `<thead><tr>
                <th class="palette-Red-500 bg" width="55%">
                <span class="palette-White text">Producto</span></th>
                <th class="palette-Grey-600 bg" width="15%"><span class="palette-White text">Cantidad</span></th>
                <th class="palette-Grey-600 bg" width="15%"><span class="palette-White text">P. Unit.</span></th>
                <th class="palette-Grey-600 bg" width="15%"><span class="palette-White text">Precio</span></th>
                </tr></thead><tbody>`;
      $.each(data, function (i, row) { 
        //numero = Number(numero.toFixed(2));
        html += `
          <tr>
            <td>${row.item_name}</td>
            <td>${Number(row.item_quantity).toFixed(2)}</td>
            <td>${Number(row.item_price).toFixed(2)}</td>
            <td>${Number(row.item_total).toFixed(2)}</td>
          </tr>
        `;
      });
      html += '</tbody></table>';
      $('#detalleventa').append(html); 
      $('#detalleVenta').modal('show');
    });

}
    
</script>