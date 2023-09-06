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
$invoice_id = $_REQUEST['invoice_id'];
$venta_detalle = $ventas_model->getVentaDetalle($invoice_id, $_REQUEST);
echo json_encode($venta_detalle);

exit(); 
