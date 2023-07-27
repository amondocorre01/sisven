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
$document->addScript('../assets/itsolution24/angular/controllers/AsignPricesController.js');
//$document->addScript('../assets/itsolution24/angular/controllers/SupplierController.js');


// Include Header and Footer
include("header.php"); 
include ("left_sidebar.php"); 
?>
<link href="../assets/estilos/estilos.css" type="text/css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Content Wrapper Start -->
<div class="content-wrapper" ng-controller="AsignPricesController">

  <!-- Content Header Start -->
  <section class="content-header">
    <h1>
      REPORTE
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
        $prices = getPrices();
        $prices = json_decode(json_encode($prices, JSON_FORCE_OBJECT));
        $pricesUser = [];
        $user_selected = '';
        if(isset($_GET['user'])){
          $user_selected = $_GET['user'];
          $pricesUser = getPricesUser($user_selected);
        }

        function searchPriceUser($idPrices, $nameCol, $pricesUser){
          $res = false;
          foreach ($pricesUser as $key => $value) {
            $valor = json_decode(json_encode($value, JSON_FORCE_OBJECT));
            $idPricesSel = $valor->id_precios;
            $nameColPiso = $valor->columna_piso;
            $nameColTecho = $valor->columna_techo;
            if($idPricesSel == $idPrices){
              if($nameCol == $nameColPiso || $nameCol == $nameColTecho){
                return true;
              }
            }
          }
          return $res;
        }
        

        $columnsPrices = getNroColumnasPrices();
        $columnsPrices = json_decode(json_encode($columnsPrices, JSON_FORCE_OBJECT));
        
        $users = getUsers();
        $users = json_decode(json_encode($users, JSON_FORCE_OBJECT));


        //var_dump($report);
        //exit();
    ?>
    
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
              <div class="row">
                <div class="col-offset-1 col-md-2">
                  <label for="">Usuario</label>
                  <select id="user" class="form-control select2 " name="user">
                      <option value="">Seleccione</option>
                      <?php foreach ($users as $key => $value) {?>
                          <?php $selUser = ($user_selected == ($value->id))?'selected':'' ?>
                          <option <?=$selUser?> value="<?php echo $value->id; ?>"><?php echo $value->username; ?></option>
                      <?php } ?>
                  </select>
                </div>

                <div class="col-offset-1 col-md-2">
                  <label for="" class="white">.</label>
                  <br>
                  <button class="btn btn-primary btn-lg" id="searchUserPrices">Buscar</button>
                </div>
                
                <div class="btn-save-prices box-body">
                  <br>
                  <?php if($user_selected):?>
                  <button class="btn btn-primary btn-lg " id="savePricesUser" ><i class="fa fa-save"></i> Guardar</button> 
                  <?php endif;?>
                </div> 
              </div>
              
            
          </div>
          
          <div class="box-body">
            <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped table-hover dataTable" style="width:100%">
                <thead>
                    <tr class="bg-gray">
                        <th>DESCRIPCION</th>
                        <?php
                          foreach ($columnsPrices as $key => $column) {
                            $nameCol = $column->COLUMN_NAME;
                            if(strpos($nameCol,  "precio") !== false){
                              $nameCol = str_replace("_", " ", strtoupper($nameCol));
                              echo "<th>$nameCol</th>";
                            }
                          }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if($user_selected):
                        foreach ($prices as $key => $value) {
                          $filas = "";
                          foreach ($columnsPrices as $key => $column) {
                            $nameCol = $column->COLUMN_NAME;
                            if(strpos($nameCol,  "precio") !== false){
                              $nameVar = '$valor = $value->'.$nameCol.';';
                              eval($nameVar);
                              $priceIsSelected = searchPriceUser($value->id, $nameCol, $pricesUser);
                              $classSelected = $priceIsSelected?'class="pricetableSelected"':'';
                              $filas .= '<td '.$classSelected.' idPrices="'.$value->id.'" nameColumn="'.$nameCol.'" onclick="selectColTablePrices(this);" style="cursor:pointer;">'.$valor.'</td>';
                            }
                          }
                            echo '<tr>
                                    <td>'.$value->descripcion.'</td>
                                    '.$filas.'
                                </tr>';
                        }
                      endif;
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
    var arrayForSave = new Array();
    $(document).ready(function(){
        initDataTable();
    });

    function getUserSelected(){
      let userSel= `<?=$user_selected?>`;
      return userSel;
    }

    function initDataTable(){
        var dt= $('#example');
        dt.dataTable({
        "processing": true,
        "lengthChange": true,
        "autoWidth": false,
        //"responsive": true,
        language:{ search: "Buscar", lengthMenu: "Mostrar _MENU_", zeroRecords: "No se encontró nada",
                        info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros", infoEmpty: "No hay registros disponibles", 
                        infoFiltered: "(Filtrado de _MAX_ registros totales)", previous: "Anterior", oPaginate: { sNext:"Siguiente", sLast: "Último", sPrevious: "Anterior", sFirst:"Primero" },                  
                        }, 
            "processing": false,
            "dom": "lfBrtip",
            "serverSide": false,
            "aLengthMenu": [
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "All"]
            ],
            "pageLength":10,
            "columnDefs": [
                {"targets": [0, 1, 2, 3], "orderable": true},
                {"className": "text-center", "targets": [ 1,2,3,4,5]},
                {"className": "text-left", "targets": [0]}
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
    }

    function selectColTablePrices(e){
        let currentValue = parseFloat($(e).text());
        if(currentValue == 0){
          window.swal('Aviso','No puede agregar un valor menor o igual a 0.',"error");
          return;
        }
        let idPrices = $(e).attr('idPrices');
        let data = {}
        data.nameColumn = $(e).attr('nameColumn');
        data.currentPrice = currentValue;

        let verif = $(e).hasClass("pricetableSelected");
        //$('#example td').removeClass("pricetableSelected");
        if(!verif){
            let  padreSuperior = $(e).parent();
            let hijos = $(padreSuperior).find('td');
            let cantidad = 0;
            hijos.each(function() { 
              let verifAnother = $(this).hasClass("pricetableSelected");
              if(verifAnother){
                cantidad ++;
              }
            });
            if(cantidad == 2){
              window.swal('Aviso','No puede agregar más precios en esta fila.',"error");
              return;
            }
            $(e).addClass("pricetableSelected");
            addDataForSave(idPrices,data);
        }else{
            removeDataForSave(idPrices,data);
            $(e).removeClass("pricetableSelected");
        }
    }
    function removeDataForSave(idPrices,d){
      let modifiedArr = arrayForSave.map(function(element){
        if(element.idPrices == idPrices){
          let arr = element.prices;
          let resultado = arr.filter(column => column.nameColumn != d.nameColumn);
          dataTemp = {}
          dataTemp.idPrices = idPrices;
          dataTemp.prices = resultado;
          return dataTemp;
        }else{
          return element;
        }
      });
      let resultadoArr = modifiedArr.filter(column => column.prices.length != 0);
      arrayForSave = resultadoArr;
    }

    function addDataForSave(idPrices,d){
      let prices_item = arrayForSave.filter(item => item.idPrices == idPrices);
      if(prices_item.length > 0){
        let arrayFound = prices_item[0].prices;
        let column_item = arrayFound.filter(item => item.nameColumn == d.nameColumn);
        if(column_item.length == 0){
            let modifiedArr = arrayForSave.map(function(element){
            if(element.idPrices == idPrices){
              let arr = element.prices;
              arr.push(d) 
              dataTemp = {}
              dataTemp.idPrices = idPrices;
              dataTemp.prices = arr;
              return dataTemp;
            }else{
              return element;
            }
          });
          arrayForSave = modifiedArr;
        }
      }else{
        addNewData(idPrices, d);
      }
    }

    function addNewData(idPrices,d){
      let prices = new Array(d);
        data = {};
        data.idPrices = idPrices;
        data.prices = prices;
        arrayForSave.push(data);
    }

    function savePricesUser(){
      let user = $('#user').val();
      if(user.trim() == ''){
        window.swal('Aviso','Seleccione un usuario.',"error");
        return;
      }
      let resultadoArr = arrayForSave.filter(column => column.prices.length === 1);
      if(resultadoArr.length > 0){
        window.swal('Aviso','Verifique los datos de la tabla, No puede haber un solo precio seleccionado en cada fila.',"error");
        return;
      }
      console.log('vamos a guardar ',arrayForSave);
    }

    

    //esta funcion funciona para una tabla sin paginacion
    /*
    function verifyPricesSelected(){
      var table = $('#example').DataTable();
      var data = table.rows().data();
      console.log('the data: ',data);

      let tbody = $('#example tbody');
      let hijosTr = $(tbody).find('tr');
      hijosTr.each(function() { 
        let hijosTd = $(this).find('td');
          let cantidad = 0;
          hijosTd.each(function() {
            let verifAnother = $(this).hasClass("pricetableSelected");
            if(verifAnother){
              cantidad ++;
            }
          });
          if(cantidad != 0 && cantidad != 2){
            window.swal('Aviso','Verifique los datos de la tabla, No puede haber un solo precio seleccionado en cada fila.',"error");
            return;
          }
      });
      return true;
    }*/
    
</script>