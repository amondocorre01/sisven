<?php 
ob_start();
session_start();
include ("../_init.php");

// Check, if user logged in or not
// If user is not logged in then return an alert message
if (!is_loggedin()) {
  header('HTTP/1.1 422 Unprocessable Entity');
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode(array('errorMsg' => trans('error_login')));
  exit();
}

// Check, if user has reading permission or not
// If user have not reading permission return an alert message
if (user_group_id() != 1 && !has_permission('access', 'read_product')) {
  header('HTTP/1.1 422 Unprocessable Entity');
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode(array('errorMsg' => trans('error_read_permission')));
  exit();
}

// LOAD PRODUCT MODEL
$ventas_model = registry()->get('loader')->model('ventas');

header('Content-Type: application/json; charset=UTF-8');
//$req = $_REQUEST['draw'];
$req = 1;
//var_dump($_REQUEST);
//$req = 1;


$ventas = $ventas_model->getVentas($_REQUEST);
//echo json_encode($ventas);
$object = json_decode(json_encode($ventas));
$producto = $_REQUEST['producto'];
$json_final= array();
foreach ($object as $key => $value) {
    $customer = get_the_customer($value->customer_id);
    $valor_customer = '';
    if (isset($customer['customer_id'])) {
        $valor_customer = $customer['customer_name'];
    }
    $the_user = get_the_user($value->created_by);
    $the_user_name='';
    if (isset($the_user['id'])) {
        $the_user_name = $the_user['username'];
    }
    $the_store = get_the_store($value->store_id);
    $the_store_name='';
    if (isset($the_store['store_id'])) {
        $the_store_name = $the_store['name'];
    }
    $object[$key]->store_name = $the_store_name;
    $object[$key]->created_by_name = $the_user_name;
    $object[$key]->customer_name = $valor_customer;

    /** Verificar si un producto esta en la venta */
    $precio_total = $ventas_model->getPriceTotal($value->invoice_id);
    //var_dump($precio_total);
    $subtotal = number_format($precio_total['subtotal'], 2, '.', '');
    $object[$key]->subtotal = $subtotal;

    $venta_detalle = $ventas_model->getVentaDetalle($value->invoice_id, $_REQUEST);
    $cant=count($venta_detalle);
    if($cant > 0){
        array_push($json_final, $object[$key]);
    }
}
if($producto){
    echo json_encode($json_final);
}else{
    echo json_encode($object);
}
exit(); 
