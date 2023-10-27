

<form id="form-purchase" class="form-horizontal" action="purchase.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="action_type" value="CREATE">
<input type="hidden" name="importacion" id="field_importacion">
  <div class="box-body">
    <div class="form-group">
      <label for="date" class="col-sm-3 control-label">
        <?php echo trans('label_date'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-6">
        <input type="text" class="form-control datepicker" name="date" autocomplete="off">
      </div>
    </div>

    <div class="form-group">
      <label for="reference_no" class="col-sm-3 control-label">
        <?php echo trans('label_reference_no'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="reference_no" name="reference_no" autocomplete="off">
      </div>
    </div>

    <div class="form-group">
      <label for="purchase-note" class="col-sm-3 control-label">
        <?php echo trans('label_note'); ?>
      </label>
      <div class="col-sm-6">
        <textarea id="purchase-note" class="form-control" name="purchase-note"></textarea>
      </div>
    </div>

    <div class="form-group hide">
      <label for="status" class="col-sm-3 control-label">
        <?php echo trans('label_status'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-6">
        <select id="status" class="form-control" name="status" >
          <option value="received"><?php echo trans('text_received'); ?></option>
          <option value="pending"><?php echo trans('text_pending'); ?></option>
          <option value="ordered"><?php echo trans('text_ordered'); ?></option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="add_attachment" class="col-sm-3 control-label">
        <?php echo trans('label_attachment'); ?>
      </label>
      <div class="col-sm-7">
        <div class="preview-thumbnail">
          <a ng-click="POSFilemanagerModal({target:'image',thumb:'image_thumb'})" onClick="return false;" href="#" data-toggle="image" id="image_thumb">
            <img src="../assets/itsolution24/img/noimage.jpg">
          </a>
          <input type="hidden" name="image" id="image" value="">
        </div>
      </div>
    </div>

    <div class="well well-sm">

      <div class="form-group sup-id-selector">
        <label for="sup_id" class="col-sm-3 control-label">
          <?php echo trans('label_supplier'); ?><i class="required">*</i>
        </label>
        <div class="col-sm-6">
          <select id="sup_id" class="form-control select2" name="sup_id">
            <option value=""><?php echo trans('text_select'); ?></option>
            <?php foreach (get_suppliers() as $sup) : ?>
              <option value="<?php echo $sup['sup_id'];?>">
                <?php echo $sup['sup_name'];?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="image" class="col-sm-3 control-label">
          <?php echo trans('label_add_product'); ?>
        </label>
        <div class="col-sm-6">
          <div class="input-group wide-tip">
            <div class="input-group-addon paddinglr-10">
              <i class="fa fa-barcode addIcon fa-2x"></i>
            </div>
            <input type="text" name="add_item" value="" class="form-control input-lg autocomplete-product" id="add_item" data-type="p_name" onkeypress="return event.keyCode != 13;" onclick="this.select();" placeholder="<?php echo trans('placeholder_search_product'); ?>" autocomplete="off" tabindex="1">
            <div class="input-group-addon paddinglr-10">
              <a id="add_new_product" href="product.php">
                <i class="fa fa-plus-circle addIcon fa-2x" id="addIcon"></i>
              </a>
            </div>
          </div>
        </div>  
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table id="product-table" class="table table-striped table-bordered mb-0">
              <thead>
                <tr class="bg-info">
                  <th class="w-35 text-center">
                    <?php echo trans('label_product'); ?>
                  </th>
                  <th class="w-10 text-center">
                    <?php echo trans('label_available'); ?>
                  </th>
                  <th class="w-10 text-center">
                    <?php echo trans('label_quantity'); ?>
                  </th>
                  <th class="w-10 text-center">
                    <?php echo trans('label_cost'); ?>
                  </th>
                  <th class="w-10 text-center">
                    <?php echo trans('label_sell_price'); ?>
                  </th>
                  <th class="w-10 text-center">
                    <?php echo trans('label_item_tax'); ?>
                  </th>
                  <th class="w-10 text-center">
                    <?php echo trans('label_item_total'); ?>
                  </th>
                  <th class="w-10 text-center">
                    OTROS COSTOS
                  </th>
                  <th class="w-10 text-center">
                    TOTAL
                  </th>
                  <th class="w-10 text-center">
                    TOTAL
                  </th>
                  <th class="w-5 text-center">
                    <i class="fa fa-trash-o"></i>
                  </th>
                </tr>
              </thead>
              <tbody>   
              </tbody>
              <tfoot>
                <tr class="bg-gray">
                  <th class="text-right" colspan="6">
                    <?php echo trans('label_subtotal'); ?>
                  </th>
                  <th class="col-sm-2 text-right">
                    <input id="total-tax" type="hidden" name="total-tax" value="">
                    <input id="total-amount" type="hidden" name="total-amount" value="">
                    <span id="total-amount-view">0.00</span>
                  </th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-gray" hidden>
                  <th class="text-right" colspan="6">
                    <?php echo trans('label_order_tax');?> (%)
                  </th>
                  <th class="col-sm-2 text-right">
                    <input ng-change="addOrderTax();" id="order-tax" class="text-right p-5" type="taxt" name="order-tax" ng-model="orderTax" onclick="this.select();" ondrop="return false;" onkeypress="return IsNumeric(event);" onpaste="return false;" autocomplete="off">
                  </th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-gray" hidden>
                  <th class="text-right" colspan="6">
                    <?php echo trans('label_shipping_charge'); ?>
                  </th>
                  <th class="col-sm-2 text-right">
                    <input ng-change="addShippingAmount();" id="shipping-amount" class="text-right p-5" type="taxt" name="shipping-amount" ng-model="shippingAmount" onclick="this.select();" ondrop="return false;" onkeypress="return IsNumeric(event);" onpaste="return false;" autocomplete="off">
                  </th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-gray" hidden>
                  <th class="text-right" colspan="6">
                    <?php echo trans('label_others_charge'); ?>
                  </th>
                  <th class="col-sm-2 text-right">
                    <input ng-change="addOthersCharge();" id="others-charge" class="text-right p-5" type="taxt" name="others-charge" ng-model="othersCharge" onclick="this.select();" ondrop="return false;" onkeypress="return IsNumeric(event);" onpaste="return false;" autocomplete="off">
                  </th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-gray" hidden>
                  <th class="text-right" colspan="6">
                    <?php echo trans('label_discount_amount'); ?>
                  </th>
                  <th class="col-sm-2 text-right">
                    <input ng-change="addDiscountAmount();" id="discount-amount" class="text-right p-5" type="taxt" name="discount-amount" ng-model="discountAmount" onclick="this.select();" ondrop="return false;" onkeypress="return IsNumeric(event);" onpaste="return false;" autocomplete="off">
                  </th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-yellow">
                  <th class="text-right" colspan="6">
                    <?php echo trans('label_payable_amount'); ?>
                  </th>
                  <th class="col-sm-2 text-right">
                    <input type="hidden" name="payable-amount" value="{{ payableAmount }}">
                    <h4 class="text-center"><b>{{ payableAmount | formatDecimal:2 }}</b></h4>
                  </th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-blue">
                  <th class="text-right" colspan="6">
                    <?php echo trans('label_payment_method'); ?>
                  </th>
                  <th class="col-sm-2 text-center">
                    <select id="pmethod-id" class="form-control select2" name="pmethod-id">
                      <?php foreach (get_pmethods() as $pmethod):?>
                        <option value="<?php echo $pmethod['pmethod_id'];?>"><?php echo $pmethod['name'];?></option>
                      <?php endforeach;?>
                    </select>
                  </th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-blue">
                  <th class="text-right" colspan="6">
                    <?php echo trans('label_paid_amount'); ?>
                  </th>
                  <th class="col-sm-2 text-right">
                    <input ng-change="addPaidAmount();" id="paid-amount" class="text-center paidAmount" type="taxt" name="paid-amount" ng-model="paidAmount" onclick="this.select();" ondrop="return false;" onkeypress="return IsNumeric(event);" onpaste="return false;" autocomplete="off">
                  </th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-gray">
                  <th colspan="2" class="w-10 text-right">
                    <?php echo trans('label_due_amount'); ?>
                  </th>
                  <th colspan="4" class="w-70 bg-red text-center">
                    <input type="hidden" name="due-amount" value="{{ dueAmount }}">
                    <span>{{ dueAmount | formatDecimal:2 }}</span>
                  </th>
                  <th colspan="2">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-gray">
                  <th colspan="2" class="w-10 text-right">
                    <?php echo trans('label_change_amount'); ?>
                  </th>
                  <th colspan="4" class="w-70 bg-green text-center">
                    <input type="hidden" name="change-amount" value="{{ changeAmount }}">
                    <span>{{ changeAmount | formatDecimal:2 }}</span>
                  </th>
                  <th colspan="2">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>

    <?php
  $concepts = getConceptosCostosImportacion();
  $concepts = json_decode(json_encode($concepts, JSON_FORCE_OBJECT));

  $proveeedores = getProveedores();
  $almacenes = getAlmacenes();
?>

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
        <div class="box-body">
          <div class="row">
            <div class="col-offset-1 col-md-6">
                  <label for="">Nro. Orden</label>
                  <input type="text" class="form-control" name="nro_orden" id="nro_orden" autocomplete="off">
              </div>

              <div class="col-offset-1 col-md-6">
                  <label for="">Razón Social</label>
                  <input type="text" class="form-control" name="razon_social" id="razon_social" autocomplete="off">
              </div>
          </div>
          <div class="row">
              <div class="col-offset-1 col-md-6">
                  <label for="">Almacen destino</label>
                  <select class="form-control" name="almacen_destino" id="almacen_destino">
                    <option value="">Seleccione</option>
                    <?php
                      foreach ($almacenes as $key => $value) {
                        $name = $value['name'];
                        $id_almacen = $value['store_id'];
                        echo '<option value="'.$id_almacen.'">'.$name.'</option>';
                      }
                    ?>  
                  <select>
              </div>

              <div class="col-offset-1 col-md-6">
                  <label for="">Nro. DUI</label>
                  <input type="text" class="form-control" name="nro_dui" id="nro_dui" autocomplete="off">
              </div>
          </div>
          <div class="row">
              <div class="col-offset-1 col-md-6">
                  
              </div>

              <div class="col-offset-1 col-md-6">
                  <label for="">Fecha</label>
                  <input type="date" class="form-control" name="fecha" id= "fecha" autocomplete="off">
              </div>
          </div>

          <table class="table-responsive">
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
                              <td><input cif="1" type="text" name="fob_refer" autocomplete="off"></td>
                              <td><input cif="1" type="text" name="fob_vbruto" onchange="calcularTotales();" onkeypress="return filterFloat(event,this);" autocomplete="off"></td>
                              <td><input cif="1" type="text" name="fob_iva" readonly onchange="calcularTotales();" onkeypress="return filterFloat(event,this);" autocomplete="off"></td>
                              <td><input cif="1" type="text" name="fob_neto" onkeypress="return filterFloat(event,this);" readonly style="background-color: #FFE680;"></td>
                              </tr>';
                          }else{
                              $s2.= '<tr>
                              <th> <input type="hidden" iden="'.$value->id.'" name="concepto" value="'.$value->concepto.'" >'.$value->concepto.'</th>
                              <td><input cif="0" type="text" name="fob_refer"></td>
                              <td><input cif="0" type="text" name="fob_vbruto" onchange="calcularTotales();" onkeypress="return filterFloat(event,this);" autocomplete="off"></td>
                              <td><input cif="0" type="text" name="fob_iva" readonly onchange="calcularTotales();" onkeypress="return filterFloat(event,this);" autocomplete="off"></td>
                              <td><input cif="0" type="text" name="fob_neto" onkeypress="return filterFloat(event,this);" readonly style="background-color: #FFE680;"></td>
                              </tr>';
                          }
                      }
                  echo $cif;
                  if($cif){
                      echo '<tr>
                      <th></th>
                      <td></td>
                      <td><input type="text" readonly id="fob_vbruto_total" name="fob_vbruto_total" onchange="calcularTotales();" onkeypress="return filterFloat(event,this);" style="background-color: #FFE680;"></td>
                      <td><input type="text" readonly id="fob_iva_total" name="fob_iva_total" onkeypress="return filterFloat(event,this);" style="background-color: #FFE680;"></td>
                      <td><input type="text" readonly id="fob_neto_total"  name="fob_neto_total" onkeypress="return filterFloat(event,this);" style="background-color: #FFE680;"></td>
                      </tr>';
                  }
                  echo $s2;
                  ?>
                  
                  <tr>
                      <th>COSTO TOTAL ALMACENES</th>
                      <td><input type="text" name="ctotal_refer"></td>
                      <td><input type="text" readonly id="ctotal_vbruto" name="ctotal_vbruto" onkeypress="return filterFloat(event,this);" style="background-color: #FFE680;"></td>
                      <td><input type="text" readonly id="ctotal_iva" name="ctotal_iva" onkeypress="return filterFloat(event,this);" style="background-color: #FFE680;"></td>
                      <td><input type="text" readonly id="ctotal_neto" name="ctotal_neto" onkeypress="return filterFloat(event,this);" style="background-color: #FFE680;"></td>
                  </tr>
              </tbody>
          </table>

        </div>
        <div>
          <!--
            <center>
              <br>
              <button class="btn btn-primary" id="btn-guardarCostosImportacion" onclick="guardarCostosImportacion();">GUARDAR COSTOS DE IMPORTACION</button>
            </center>-->
        </div>
      </div>
    </div>
  </div>
</section>

    <div class="form-group">
      <div class="col-sm-4 col-sm-offset-3 text-center">            
        <button id="create-purchase-submit" class="btn btn-block btn-lg btn-info" data-form="#form-purchase" data-datatable="#purchase-purchase-list" name="submit" data-loading-text="Processing...">
          <i class="fa fa-fw fa-save"></i>
          <?php echo trans('button_submit'); ?>
        </button>
      </div>
      <div class="col-sm-2 text-center">            
        <button type="reset" class="btn btn-block btn-lg btn-danger" id="reset" name="reset">
          <span class="fa fa-fw fa-circle-o"></span>
          <?php echo trans('button_reset'); ?>
        </button>
      </div>
    </div>


  </div>
  


</form>

<script type="text/javascript">
$(document).ready(function() {
  let imp=`<a href="purchase_importacion.php?editar_hoja_importacion=1" class="btn btn-warning">Editar Costos de Importación</a>`;
  let datos_imp = localStorage.getItem('importacion');
  if(datos_imp){
    $('#edt_import').html(imp);
  }

  $('.datepicker').datepicker({
    language: langCode,
    format: "yyyy-mm-dd",
    autoclose:true,
    todayHighlight: true
  }).datepicker("setDate",'now');
});

//Add importaciones

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
  return false;
}

function buscarDatos(){
  var dt= $('#example');
  $(dt).DataTable().ajax.reload(null, false);
}

function calcularTotales(){
  let fob_vbruto = document.getElementsByName("fob_vbruto");
  let fob_iva = document.getElementsByName("fob_iva");
  let fob_neto = document.getElementsByName("fob_neto");
  let suma_cif1 = 0;
  let suma_cif0 = 0;
  let suma_iva_cif1 = 0;
  let suma_iva_cif0 = 0;
  let suma_netos = 0;

  fob_vbruto.forEach((element,key) => {
    let val = $(element).val();
    if(val == ''){
      val=0;
    }
    val= parseFloat(val);
    let iva = Number((val*0.13)).toFixed(2);
    $(fob_iva[key]).val(iva);
    let valor_iva = $(fob_iva[key]).val();
    if(valor_iva == ''){
      valor_iva = 0;
    }else{
      valor_iva = parseFloat(valor_iva);
    }
    let valor_cif = $(element).attr('cif');
    
    let val_neto = Number((val - valor_iva)).toFixed(2);
    $(fob_neto[key]).val(val_neto);
      if(valor_cif == '1'){
        suma_cif1 += parseFloat(val);
        suma_iva_cif1 += parseFloat(valor_iva);
      }else{
        suma_cif0 += parseFloat(val);
        suma_iva_cif0 += parseFloat(valor_iva);
      }
      val_neto = parseFloat(val_neto);
      suma_netos += val_neto;

  });
  
  $('#fob_vbruto_total').val(suma_cif1);
  $('#ctotal_vbruto').val(suma_cif0);

  $('#fob_iva_total').val(suma_iva_cif1);
  $('#ctotal_iva').val(suma_iva_cif0);
  suma_netos = Number(suma_netos).toFixed(2);
  $('#ctotal_neto').val(suma_netos);
  calcularCostosTabla();
}

function calcularCostosTabla(){
  var datos_tabla = ($("#product-table>tbody").html()).trim();
  if(datos_tabla ==''){   
      alert('Agregue productos de la compra.');
      return;
  }

  let neto = $('#ctotal_neto').val();
  neto = parseFloat(neto);
  $("#product-table>tbody").find("tr").each(function () {
    let item = $(this).data('item-id');
    let subtotal_f = $(`#subtotal-${item}`).html();
    let total_f = $('#paid-amount').val();
    let precio_compra_ref = $(`#purchase-price-${item}`).val();
    subtotal_f = parseFloat(subtotal_f);
    total_f = parseFloat(total_f);
    precio_compra_ref = parseFloat(precio_compra_ref);
    let otros_costos = 0;
    if(total_f >0){
       otros_costos = ((subtotal_f/total_f)*neto)-precio_compra_ref;
    }

    otros_costos = Number(otros_costos).toFixed(2);
    $(`#add2-${item}`).html(otros_costos);

    let price_row = $(`#purchase-price-${item}`).val();
    let price_new_pu = parseFloat(price_row) + parseFloat(otros_costos);
    price_new_pu = Number(price_new_pu).toFixed(2);
    $(`#add3-${item}`).val(price_new_pu);
    let quantity_row = $(`#quantity-${item}`).val();
    let price_total_row = parseFloat(quantity_row) * parseFloat(price_new_pu);
    price_total_row = Number(price_total_row).toFixed(2);
    $(`#add4-${item}`).val(price_total_row);
  });


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
      /*
      let valIva = parseFloat(valor_iva);
      let valBru = parseFloat(val);
      if(valIva == 0 && valBru == 0){

      }
      

      if(val == ''){
        let concepto = $(conceptos[key]).val();
        alert('Verifique los valores de la tabla. :'+concepto+', no contiene el valor bruto');
        res= false;
      }  */
    }
  });
  return res;
}

//async function guardarCostosImportacion(){
  function getDatosImportacion(){
  let nro_orden = $('#nro_orden').val();
  let razon_social = $('#razon_social').val();
  let almacen_destino = $('#almacen_destino').val();
  let fecha = $('#fecha').val();
  let nro_dui = $('#nro_dui').val();

  let importacion = {};
  importacion.nro_orden= nro_orden;
  importacion.razon_social= razon_social;
  importacion.almacen_destino= almacen_destino;
  importacion.fecha= fecha;
  importacion.nro_dui= nro_dui;
  let valid = validadDataTabla();
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

    return JSON.stringify(importacion);
    //localStorage.setItem('importacion', JSON.stringify(importacion));
    //window.swal("Success", 'Se ha guardado temporalmente los datos.', "success");
    //setTimeout(() => { window.location.href = "purchase.php"; }, 1000); 
  }
  
}

function loadEdit(){
  let datos_imp = localStorage.getItem('importacion');


  if(datos_imp){
    datos_imp = JSON.parse(datos_imp);
    $('#nro_orden').val(datos_imp.nro_orden);
    $('#razon_social').val(datos_imp.razon_social);
    $('#almacen_destino').val(datos_imp.almacen_destino);
    $('#fecha').val(datos_imp.fecha);
    $('#productos_data').val(datos_imp.productos_data);
    $('#nro_dui').val(datos_imp.nro_dui);
    $('#proveedor').val(datos_imp.proveedor);

    let importaciones_array = datos_imp.importaciones;

    let fob_refer = document.getElementsByName("fob_refer");
    let fob_vbruto = document.getElementsByName("fob_vbruto");
    let fob_iva = document.getElementsByName("fob_iva");
    let fob_neto = document.getElementsByName("fob_neto");
    let conceptos = document.getElementsByName("concepto");

    var importaciones = new Array();
    fob_vbruto.forEach((element,key) => {
      $(fob_refer[key]).val(importaciones_array[key].valor_referencia);
      $(fob_vbruto[key]).val(importaciones_array[key].valor_bruto);
      $(fob_iva[key]).val(importaciones_array[key].valor_iva);
      $(fob_neto[key]).val(importaciones_array[key].valor_neto);
    });
    calcularTotales();
  }
}

$(document).ready(function(){     
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);                        
  let urlHas = urlParams.has('editar_hoja_importacion');
  if(urlHas){
    loadEdit();
  }
  let urlHasView = urlParams.has('ver_hoja_importacion');
  if(urlHasView){
    $('#btn-guardarCostosImportacion').hide();
    $("input").attr('readonly',true);
    let invoice_iden = urlParams.get('ver_hoja_importacion');
    loadView(invoice_iden);
  }
});

function loadView(id){
  $.post('../_inc/importacion_view.php', {invoice_id:id})
    .done(function (datos_imp) {
      $('#nro_orden').val(datos_imp.nro_orden);
      $('#razon_social').val(datos_imp.razon_social);
      $('#almacen_destino').val(datos_imp.almacen_destino);
      $('#fecha').val(datos_imp.fecha);
      $('#productos_data').val(datos_imp.productos_data);
      $('#nro_dui').val(datos_imp.nro_dui);
      $('#proveedor').val(datos_imp.proveedor);

      let importaciones_array = datos_imp.importaciones;

      let fob_refer = document.getElementsByName("fob_refer");
      let fob_vbruto = document.getElementsByName("fob_vbruto");
      let fob_iva = document.getElementsByName("fob_iva");
      let fob_neto = document.getElementsByName("fob_neto");
      let conceptos = document.getElementsByName("concepto");

      var importaciones = new Array();
      fob_vbruto.forEach((element,key) => {
        $(fob_refer[key]).val(importaciones_array[key].valor_referencia);
        $(fob_vbruto[key]).val(importaciones_array[key].valor_bruto);
        $(fob_iva[key]).val(importaciones_array[key].valor_iva);
        $(fob_neto[key]).val(importaciones_array[key].valor_neto);
      });
      calcularTotales();
    });
}

function resetFormulario(){
  $('.table-responsive input').each(function () {
        $(this).val('')
      })
}

</script>