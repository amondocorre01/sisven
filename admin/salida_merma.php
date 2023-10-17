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
<!--
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.6.0/css/autoFill.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
-->
<!--
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/autofill/2.6.0/js/dataTables.autoFill.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>-->

<!-- Content Wrapper Start -->
<div class="content-wrapper">

  <!-- Content Header Start -->
  <section class="content-header">
    <h1>
      SALIDA DE MERMA
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
        SALIDA DE MERMA
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

        $stores = getStores();
        $stores = json_decode(json_encode($stores, JSON_FORCE_OBJECT));

        $productos = getProductsAll();
        $productos = json_decode(json_encode($productos, JSON_FORCE_OBJECT));

        $lista = getBajasProductos();
        $lista = json_decode(json_encode($lista, JSON_FORCE_OBJECT));


        //var_dump($report);
        //exit();
    ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">
              
            </h3>
            
            <div class="row">
                <div class="col-offset-1 col-md-2">
                    <label for="">Almacen</label>
                    <select id="store_id" class="form-control select2 " name="store_id">
                        <option value="">Seleccione</option>
                        <?php foreach ($stores as $key => $value) {?>
                            <option value="<?php echo $value->store_id; ?>"><?php echo $value->name; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-offset-1 col-md-2">
                    <label for="">Producto</label>
                    <select id="product_id" class="form-control select2 " name="product_id">
                        <option value="">Seleccione</option>
                        <?php foreach ($productos as $key => $value) {?>
                            <option value="<?php echo $value->p_id; ?>"><?php echo $value->p_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="col-offset-1 col-md-2">
                    <label for="">Stock</label>
                    <input type="text" class="form-control" id="stock_producto" name="stock_producto" readonly>
                </div>

                <div class="col-offset-1 col-md-2">
                    <label for="">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad_producto" name="cantidad_producto">
                </div>


                <div class="col-offset-1 col-md-2">
                <label for="" class="white">.</label>
                <br>
                <button class="btn btn-primary btn-lg" onclick="guardarMerma(this)">Guardar</button>
                </div>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped table-hover dataTable" style="width:100%">
                <thead>
                    <tr class="bg-gray">
                        <th>ALMACEN</th>    
                        <th>PRODUCTO</th>
                        <th>CANTIDAD</th>
                        <th>FECHA</th>
                        <th>ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($lista as $key => $value) {
                            echo "<tr>
                                    <td>$value->store</td>
                                    <td>$value->product</td>
                                    <td>$value->cantidad</td>
                                    <td>$value->fecha</td>
                                    <td>$value->estado</td>
                                </tr>";
                        }
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

<?php include ("footer.php"); ?>
<script>
    //new DataTable('#example');
    $(document).ready(function(){


      
      

    
    var dt= $('#example');
    dt.dataTable({
      "processing": true,
      "lengthChange": true,
      "autoWidth": false,
      /*"ajax": {
                url: "../_inc/report_productos.php",
                dataSrc: "data"
               },
      "columns": [
        { "data": "name" },
        { "data": "position" },
        { "data": "office" },
        {
          sortable: false,
          "render": function ( data, type, row, meta ) {
              var buttonID = "rollover_"+row.id;
              if(row.edit){
                return '<a id='+buttonID+' class="btn btn-success editarBtn" role="button">Editar</a>';
              }
              return '';
          }
        }
      ],*/
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

$("#store_id").change(function() {
    searchStock();
});

$("#product_id").change(function() {
  searchStock();
});

function searchStock(){
  let store = $("#store_id").val();
  let product = $("#product_id").val();
  $('#stock_producto').val('');
    $('#cantidad_producto').val('');
  if(store !='' && product != ''){
    console.log('searching stock actual');
    $.post('../_inc/api_merma.php', {store_id:store, product_id:product, action:'search-stock'})
    .done(function (resp_datos) {
      let resp = JSON.parse(resp_datos);
      if(resp){
        if(resp.length >0){
          let stock = resp[0].quantity_in_stock;
          stock = Number(stock).toFixed(2);
          $('#stock_producto').val(stock);
        }else{
          $('#stock_producto').val('0');
        } 
      }
    });
  }

}

function guardarMerma(e){
  let store = $("#store_id").val();
  let product = $("#product_id").val();
  let cantidad = $("#cantidad_producto").val();
  let stock = $('#stock_producto').val();
  if(store !='' && product != '' && cantidad != ''){
    stock = parseFloat(stock);
    cantidad = parseFloat(cantidad);
    if(cantidad <= 0){
      alert('Ingrese una cantidad mayor a 0');
      return;
    }
    if(cantidad > stock){
      alert('La cantidad ingresada es mayor que el stock');
      return;
    }
    $(e).attr('disabled',true);
    let datos = {
      store_id: store,
      product_id: product,
      cantidad: cantidad,
      stock: stock,
      action:'save-merma'
    }
    $.post('../_inc/api_merma.php', datos)
    .done(function (resp_datos) {
      let resp = JSON.parse(resp_datos);
      if(resp){
        console.log('respuesta',resp);
        if(resp.status){
          window.swal("Success", 'Se ha guardado los datos.', "success");
          setTimeout(() => { window.location.href = "salida_merma.php"; }, 1000);
        }else{
          $(e).attr('disabled',false);
          window.swal('Aviso','Ocurrio un error.',"error");
          return;
        }
      }else{
        $(e).attr('disabled',false);
        window.swal('Aviso','Ocurrio un error.',"error");
        return;
      }
    });
  }
}
    
</script>