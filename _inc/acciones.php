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
$acciones_model = registry()->get('loader')->model('acciones');
$data = json_decode(file_get_contents('php://input'), false);

if ($request->server['REQUEST_METHOD'] == 'POST' && isset($data->action_type) && $data->action_type == 'SAVEPRICESUSER'){ 
  try{  
    $res = $acciones_model->savePricesUser($data);
    $obj = new stdClass();
    $obj->status=$res;
    header('Content-Type: application/json');
    echo json_encode(array('msg' => "Guardado correctamente"));
    exit();
    }catch (Exception $e) { 
      header('HTTP/1.1 422 Unprocessable Entity');
      header('Content-Type: application/json; charset=UTF-8');
      echo json_encode(array('errorMsg' => $e->getMessage()));
      exit();
  }
}

if ($request->server['REQUEST_METHOD'] == 'POST' && isset($data->action_type) && $data->action_type == 'GETPRICESSUSER'){ 
  try{  
    $res = $acciones_model->getPricesUser($data->userSelected);
    header('Content-Type: application/json');
    echo json_encode($res);
    exit();
    }catch (Exception $e) { 
      header('HTTP/1.1 422 Unprocessable Entity');
      header('Content-Type: application/json; charset=UTF-8');
      echo json_encode(array('errorMsg' => $e->getMessage()));
      exit();
  }
}
