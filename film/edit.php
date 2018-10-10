<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/includes.php';

if(!isset($_GET['id'])){
    echo '{';
    echo '"message": "You need to specify an ID."';
    echo '}';
    exit;
}

$id = $_GET['id'];

// get posted data
$data = json_decode(file_get_contents("php://input"));
// turn json to array so I can construct a new class object
$array = (array) $data;

$db = new DB();
$model = new Film($array);
// check that the $_GET['id'] matches the id in the object that was send
if($id != $model->ID)
{
    echo '{';
    echo '"message": "The id of the request does not match the sent ID!"';
    echo '}';
    exit;
}

$response = $db->edit("Films", "film", $model, $id);

if($response){
    echo '{';
    echo '"message": "Film succesvol geupdated."';
    echo '}';
}
else
{
    echo '{';
    echo '"message": "Film is niet geupdated!."';
    echo '}';
}
?>