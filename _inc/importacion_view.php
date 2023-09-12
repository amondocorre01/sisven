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

$store_id = store_id();
$user_id = user_id();

// LOAD INVOICE MODEL
$invoice_model = registry()->get('loader')->model('purchase');

if(isset($request->post['invoice_id'])){
    $invoice_id = $request->post['invoice_id'];
    $sql1 = "select * FROM hoja_importacion WHERE invoice_id='$invoice_id' LIMIT 1;";
    $result = db()->query($sql1);
    $result = $result->fetch(PDO::FETCH_ASSOC);
    $result = json_decode(json_encode($result),false);
    $object = new stdClass();
	$object->almacen_destino = $result->almacen_destino;
    $object->fecha = $result->fecha;
    $object->nro_dui = $result->nro_dui;
    $object->nro_orden = $result->nro_orden;
    $object->productos_data = $result->productos;
    $object->proveedor = $result->proveedor;
    $object->razon_social = $result->razon_social;
    $object->importaciones = [];
    $sql2 = "select * FROM costos_importacion WHERE invoice_id='$invoice_id' ORDER BY id_concepto ASC;";
    $result2 = db()->query($sql2);
    $result2 = $result2->fetchAll(PDO::FETCH_ASSOC);
    $result2 = json_decode(json_encode($result2),false);
    $arrayPO = array();
    foreach ($result2 as $key => $value) {
        $importaciones = new stdClass();
        $importaciones->id_concepto = $value->id_concepto;
        $importaciones->concepto = '';
        $importaciones->valor_bruto = $value->valor_bruto;
        $importaciones->valor_iva = $value->iva;
        $importaciones->valor_neto = $value->valor_neto;
        $importaciones->valor_referencia = $value->datos_referencia;
        array_push($arrayPO, $importaciones);
    }
    $object->importaciones = $arrayPO;
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($object);
}

