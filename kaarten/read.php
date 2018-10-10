<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/includes.php';


if(isset($_GET['id'])){
    //Get 1 record
    $id = $_GET['id'];
    $readDB = new DB();
    //Get data from database {Table_name, class_name}
    $records = $readDB->readID("Kaarten", "kaarten", $id);
    echo $records;
}
else
{
    //Get all records
    $readDB = new DB();
    //Get data from database {Table_name, class_name}
    $records = $readDB->read("Kaarten", "kaarten");
    echo $records;
}

?>