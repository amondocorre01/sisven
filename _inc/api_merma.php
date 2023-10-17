<?php 
ob_start();
session_start();
include ("../_init.php");

// Check, if user logged in or not
// If user is not logged in then return error
if (!is_loggedin()) {
  header('HTTP/1.1 422 Unprocessable Entity');
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode(array('errorMsg' => trans('error_login')));
  exit();
}

// Check, if user has reading permission or not
// If user have not reading permission return error
if (user_group_id() != 1 && !has_permission('access', 'read_bank_account_sheet')) {
  header('HTTP/1.1 422 Unprocessable Entity');
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode(array('errorMsg' => trans('error_read_permission')));
  exit();
}
if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch ($action) {
        case 'search-stock':
            searchStock();
            break;
        case 'save-merma':
            saveMerma();
            break;
        default:
            # code...
            break;
    }
    
}

function searchStock(){
    if(isset($_POST['product_id'] ) && isset($_POST['store_id'])){
        $product_id = $_POST['product_id'];
        $store_id = $_POST['store_id'];
        $sql = "select * from product_to_store where product_id='$product_id' and store_id='$store_id' and status='1';";
        $result = db()->query($sql);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }else{
        $array = array();
        echo json_encode($array);
    }
}

function saveMerma(){
    if(isset($_POST['product_id'] ) && isset($_POST['store_id']) && isset($_POST['cantidad']) && isset($_POST['stock'])){
        $product_id = $_POST['product_id'];
        $store_id = $_POST['store_id'];
        $cantidad = $_POST['cantidad'];
        $stock = $_POST['stock'];
        $cantidad = floatval($cantidad);
        $stock = floatval($stock);
        $resto = $stock-$cantidad;
        $sql = "update product_to_store set quantity_in_stock='$resto' where product_id='$product_id' and store_id='$store_id' and status='1'";
        db()->query($sql);
        $usuario = user_id();
        $fecha = date('Y-m-d H:i:s');
        $sql2 = "insert into bajas_productos(store_id, product_id,cantidad,estado,usuario,fecha)values('$store_id','$product_id','$cantidad','1','$usuario','$fecha');";
        db()->query($sql2);
        $insertado = db()->lastInsertId();
        if($insertado){
            $array = array();
            $array['status']=true;
            echo json_encode($array);       
        }else{
            $array = array();
            $array['status']=false;
            echo json_encode($array);
        }
    }else{
        $array = array();
        echo json_encode($array);
    }
}




