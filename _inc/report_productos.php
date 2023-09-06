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
$product_model = registry()->get('loader')->model('product');

header('Content-Type: application/json; charset=UTF-8');
//$req = $_REQUEST['draw'];
$req = 1;
//var_dump($_REQUEST);
//$req = 1;
$resp = ' {"draw": '.$req.',
"recordsTotal": 6,
"recordsFiltered": 18,
"data":[
    {
      "id": 1,
       "name": "John",
       "position": "Product Manager",
       "office": "sds",
       "salary": 142557,
       "address": "54,komal street",
       "edit": true
    },
    {
      "id": 2,
       "name": "Bob",
       "position": "Data Analyst",
       "office": "Tokyo",
       "salary": 103692,
       "address": "54,komal street",
       "edit": false
    },
    {
      "id": 3,
       "name": "Alice",
       "position": "Marketing Manager",
       "office": "San Francisco",
       "salary": 109669,
       "address": "54,komal street",
       "edit": true
    },
    {
      "id": 4,
       "name": "Steve",
       "position": "Data Analyst",
       "office": "New York",
       "salary": 130649,
       "address": "54,komal street",
       "edit": true
    },
    {
      "id": 5,
       "name": "Bob",
       "position": "Software Engineer",
       "office": "Paris",
       "salary": 106573,
       "address": "54,komal street",
       "edit": true
    },
    {
      "id": 6,
        "name": "Bob2",
        "position": "Software Engineer",
        "office": "Paris",
        "salary": 106573,
        "address": "54,komal street",
        "edit": true
     }
 ]
   }';

$resp = json_decode($resp,false);
echo json_encode($resp);

