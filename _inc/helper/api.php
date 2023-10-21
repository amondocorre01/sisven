<?php

function getReportProducts(){
	$model = registry()->get('loader')->model('reportes');
	return $model->getReportProducts();
}
function getCustomers(){
	$model = registry()->get('loader')->model('customer');
	return $model->getCustomersAll();
}

function getSuppliers(){
	$model = registry()->get('loader')->model('reportes');
	return $model->getSuppliers();
}

function getCategories(){
	$model = registry()->get('loader')->model('reportes');
	return $model->getCategories();
}

function getStores(){
	$model = registry()->get('loader')->model('reportes');
	return $model->getStores();
}

//Asignacion de permisos de precios
function getUsers(){
	$model = registry()->get('loader')->model('reportes');
	return $model->getUsers();
}
function getPrices(){
	$model = registry()->get('loader')->model('reportes');
	return $model->getPrices();
}

function getNroColumnasPrices(){
	$model = registry()->get('loader')->model('reportes');
	return $model->getNroColumnasPrices();
}

function getPricesUser($user){
	$model = registry()->get('loader')->model('acciones');
	return $model->getPricesUser($user);
}

function getProducts(){
	$model = registry()->get('loader')->model('product');
	return $model->getProducts();
}
function getProductsAll(){
	$model = registry()->get('loader')->model('product');
	return $model->getProductsAll();
}
function getConceptosCostosImportacion(){
	$model = registry()->get('loader')->model('purchase');
	return $model->getConceptosCostosImportacion();
}

function getBajasProductos(){
	$model = registry()->get('loader')->model('product');
	return $model->getBajasProductos();
}

function getCompras($fecha_inicial,$fecha_final,$store_id,$product_id){
	$model = registry()->get('loader')->model('purchase');
	return $model->getCompras($fecha_inicial,$fecha_final,$store_id,$product_id);
}
function getVentas($fecha_inicial,$fecha_final,$store_id,$product_id){
	$model = registry()->get('loader')->model('invoice');
	return $model->getVentas($fecha_inicial,$fecha_final,$store_id,$product_id);
}

function getTransferenciasSalida($fecha_inicial,$fecha_final,$store_id,$product_id){
	$model = registry()->get('loader')->model('transfer');
	return $model->getTransferenciasSalida($fecha_inicial,$fecha_final,$store_id,$product_id);
}
function getTransferenciasEntrada($fecha_inicial,$fecha_final,$store_id,$product_id){
	$model = registry()->get('loader')->model('transfer');
	return $model->getTransferenciasEntrada($fecha_inicial,$fecha_final,$store_id,$product_id);
}
function limpiarKardex($iden){
	$model = registry()->get('loader')->model('transfer');
	return $model->limpiarKardex($iden);
}
function agregarKardex($iden,$fecha,$detalle,$ingreso,$salida,$pCosto,$ingVal,$salVal){
	$model = registry()->get('loader')->model('transfer');
	return $model->agregarKardex($iden,$fecha,$detalle,$ingreso,$salida,$pCosto,$ingVal,$salVal);
}
function obtenerKardex($iden){
	$model = registry()->get('loader')->model('transfer');
	return $model->obtenerKardex($iden);
}
?>