<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/includes.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    // get all records
    $readDB = new DB();
    //Get data from database {Table_name, class_name}
    $records = $readDB->readID("Zaal", "zaal", $id);
    echo $records;
}
else
{
    // get all records
    $readDB = new DB();
    //Get data from database {Table_name, class_name}
    $records = $readDB->read("Zaal", "zaal");
    echo $records;
}

?>