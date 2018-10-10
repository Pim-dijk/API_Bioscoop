<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/includes.php';

// get posted data
$data = json_decode(file_get_contents("php://input"));
// turn json to array so I can construct a new class object
$array =  (array) $data;

$db = new DB();
$model = new Film($array);

//{Table_name, class_name, id}
$response = $db->create("Films", "film", $model);

if($response){
    echo '{';
    echo '"message": "Film succesvol toegevoegd."';
    echo '}';
}
else
{
    echo '{';
    echo '"message": "Film is niet toegevoegd!."';
    echo '}';
}

?>