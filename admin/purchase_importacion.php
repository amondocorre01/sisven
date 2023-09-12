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
$concepts = getConceptosCostosImportacion();
$concepts = json_decode(json_encode($concepts, JSON_FORCE_OBJECT));

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
      HOJA DE COSTOS DE IMPORTACION
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
      HOJA DE COSTOS DE IMPORTACION
      </li>
    </ol>
  </section>
  <!-- Content Header End -->

  <!-- Content Start -->
      <a href="purchase.php" style="float:right; margin-top: 20px; margin-right:20px" class="btn btn-primary">Volver</a>
    
  

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
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title"></h3>
          </div>
          <form action="">
          <div class="box-body">
            <div class="row">
              <div class="col-offset-1 col-md-6">
                    <label for="">Nro. Orden</label>
                    <input type="text" class="form-control" name="nro_orden" id="nro_orden">
                </div>

                <div class="col-offset-1 col-md-6">
                    <label for="">Razón Social</label>
                    <input type="text" class="form-control" name="razon_social" id="razon_social" >
                </div>
            </div>
            <div class="row">
              <div class="col-offset-1 col-md-6">
                    <label for="">Proveedor</label>
                    <input type="text" class="form-control" name="proveedor" id="proveedor">
                </div>

                <div class="col-offset-1 col-md-6">
                    <label for="">Nro. DUI</label>
                    <input type="text" class="form-control" name="nro_dui" id="nro_dui">
                </div>
            </div>
            <div class="row">
              <div class="col-offset-1 col-md-6">
                    <label for="">Almacen destino</label>
                    <input type="text" class="form-control" name="almacen_destino" id="almacen_destino">
                </div>

                <div class="col-offset-1 col-md-6">
                    <label for="">Fecha</label>
                    <input type="text" class="form-control" name="fecha" id= "fecha">
                </div>
            </div>

            <div class="row">
              <div class="col-offset-1 col-md-12">
                    <label for="">Productos</label>
                    <input type="text" class="form-control" name="productos_data" id="productos_data">
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>CONCEPTO</th>
                        <th>DATOS REFERENCIA</th>
                        <th>VALOR BRUTO</th>
                        <th>IVA</th>
                        <th>VALOR NETO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $cif = '';
                        $s2 = '';
                        foreach ($concepts as $key => $value) {
                            if($value->cif){
                                $cif.= '<tr>
                                <th><input type="hidden" iden="'.$value->id.'" name="concepto" value="'.$value->concepto.'" >  '.$value->concepto.'</th>
                                <td><input cif="1" type="text" name="fob_refer"></td>
                                <td><input cif="1" type="text" name="fob_vbruto" onchange="calcularTotales(this);" onkeypress="return filterFloat(event,this);"></td>
                                <td><input cif="1" type="text" name="fob_iva" onchange="calcularTotales(this);" onkeypress="return filterFloat(event,this);"></td>
                                <td><input cif="1" type="text" name="fob_neto" onkeypress="return filterFloat(event,this);" readonly></td>
                                </tr>';
                            }else{
                                $s2.= '<tr>
                                <th> <input type="hidden" iden="'.$value->id.'" name="concepto" value="'.$value->concepto.'" >'.$value->concepto.'</th>
                                <td><input cif="0" type="text" name="fob_refer"></td>
                                <td><input cif="0" type="text" name="fob_vbruto" onchange="calcularTotales(this);" onkeypress="return filterFloat(event,this);"></td>
                                <td><input cif="0" type="text" name="fob_iva" onchange="calcularTotales(this);" onkeypress="return filterFloat(event,this);"></td>
                                <td><input cif="0" type="text" name="fob_neto" onkeypress="return filterFloat(event,this);"></td>
                                </tr>';
                            }
                        }
                    echo $cif;
                    if($cif){
                        echo '<tr>
                        <th></th>
                        <td></td>
                        <td><input type="text" readonly id="fob_vbruto_total" name="fob_vbruto_total" onchange="calcularTotales(this);" onkeypress="return filterFloat(event,this);"></td>
                        <td><input type="text" readonly id="fob_iva_total" name="fob_iva_total" onkeypress="return filterFloat(event,this);"></td>
                        <td><input type="text" readonly id="fob_neto_total"  name="fob_neto_total" onkeypress="return filterFloat(event,this);"></td>
                        </tr>';
                    }
                    echo $s2;
                    ?>
                    
                    <tr>
                        <th>COSTO TOTAL ALMACENES</th>
                        <td><input type="text" name="ctotal_refer"></td>
                        <td><input type="text" readonly id="ctotal_vbruto" name="ctotal_vbruto" onkeypress="return filterFloat(event,this);"></td>
                        <td><input type="text" readonly id="ctotal_iva" name="ctotal_iva" onkeypress="return filterFloat(event,this);"></td>
                        <td><input type="text" readonly id="ctotal_neto" name="ctotal_neto" onkeypress="return filterFloat(event,this);"></td>
                    </tr>
                </tbody>
            </table>

          </div>
          </form>
          <div>
              <center>
                <br>
                <button class="btn btn-primary" onclick="guardarCostosImportacion();">GUARDAR</button>
              </center>
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
$("input.numeros").bind('keypress', function(event) {
        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    function filterFloat(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46 || key == 44){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}

function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}

function valida(e){
  console.log('Validando el formulario');
  return false;
}

function buscarDatos(){
  var dt= $('#example');
  $(dt).DataTable().ajax.reload(null, false);
}

function calcularTotales(e){
  let fob_vbruto = document.getElementsByName("fob_vbruto");
  let fob_iva = document.getElementsByName("fob_iva");
  let fob_neto = document.getElementsByName("fob_neto");
  let suma_cif1 = 0;
  let suma_cif0 = 0;
  let suma_iva_cif1 = 0;
  let suma_iva_cif0 = 0;

  fob_vbruto.forEach((element,key) => {
    let valor_iva = $(fob_iva[key]).val();
    if(valor_iva == ''){
      valor_iva = 0;
    }else{
      valor_iva = parseFloat(valor_iva);
    }
    let valor_cif = $(element).attr('cif');
    let val = $(element).val();
    if(val == ''){
      val=0;
    }
    let val_neto = val - valor_iva;
    $(fob_neto[key]).val(val_neto);

    //console.log(val);
      if(valor_cif == '1'){
        suma_cif1 += parseFloat(val);
        suma_iva_cif1 += parseFloat(valor_iva);
      }else{
        suma_cif0 += parseFloat(val);
        suma_iva_cif0 += parseFloat(valor_iva);
      }
  });
  //console.log(suma_cif1);
  $('#fob_vbruto_total').val(suma_cif1);
  $('#ctotal_vbruto').val(suma_cif0);

  $('#fob_iva_total').val(suma_iva_cif1);
  $('#ctotal_iva').val(suma_iva_cif0);
}

function validadDataTabla(){
  let fob_vbruto = document.getElementsByName("fob_vbruto");
  let fob_iva = document.getElementsByName("fob_iva");
  let fob_neto = document.getElementsByName("fob_neto");
  let conceptos = document.getElementsByName("concepto");
  let res = true;
  fob_vbruto.forEach((element,key) => {
    let valor_iva = $(fob_iva[key]).val();
    if(valor_iva != ''){
      let val = $(element).val();
      if(val == ''){
        let concepto = $(conceptos[key]).val();
        alert('Verifique los valores de la tabla. :'+concepto+', no contiene el valor bruto');
        res= false;
      }  
    }
  });
  return res;
}

async function guardarCostosImportacion(){
  let nro_orden = $('#nro_orden').val();
  let razon_social = $('#razon_social').val();
  let almacen_destino = $('#almacen_destino').val();
  let fecha = $('#fecha').val();
  let productos_data = $('#productos_data').val();
  let nro_dui = $('#nro_dui').val();
  let proveedor = $('#proveedor').val();

  let importacion = {};
  importacion.nro_orden= nro_orden;
  importacion.razon_social= razon_social;
  importacion.almacen_destino= almacen_destino;
  importacion.fecha= fecha;
  importacion.productos_data= productos_data;
  importacion.nro_dui= nro_dui;
  importacion.proveedor= proveedor;
  let valid = await validadDataTabla();
  console.log('res',valid);
  if(valid == true){
    // almacenando en array
    
    let fob_refer = document.getElementsByName("fob_refer");
    let fob_vbruto = document.getElementsByName("fob_vbruto");
    let fob_iva = document.getElementsByName("fob_iva");
    let fob_neto = document.getElementsByName("fob_neto");
    let conceptos = document.getElementsByName("concepto");
    var importaciones = new Array();
    fob_vbruto.forEach((element,key) => {
      let valor_referencia = $(fob_refer[key]).val();
      let valor_bruto = $(fob_vbruto[key]).val();
      let valor_iva = $(fob_iva[key]).val();
      let valor_neto = $(fob_neto[key]).val();
      let concepto = $(conceptos[key]).val();
      let iden = $(conceptos[key]).attr('iden');
      let row = {};
      row.id_concepto= iden;
      row.concepto= concepto;
      row.valor_bruto= valor_bruto;
      row.valor_iva= valor_iva;
      row.valor_neto= valor_neto;
      row.valor_referencia = valor_referencia;
      importaciones.push(row);
    });
    importacion.importaciones = importaciones;
    localStorage.setItem('importacion', JSON.stringify(importacion));
    window.swal("Success", 'Se ha guardado temporalmente los datos.', "success");
    setTimeout(() => { window.location.href = "purchase.php"; }, 1000);
    
  }
  
}

function loadEdit(){
  let datos_imp = localStorage.getItem('importacion');
  datos_imp = JSON.parse(datos_imp);
}

$(document).ready(function(){     
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);                        
  console.log('aaa',urlParams.has('editar_hoja_importacion'));   
});

    
</script>