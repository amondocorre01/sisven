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
?>