<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/includes.php';


// case to determine the page
$class_name = "";
$table_name = "";
$page = $_GET['page'];

switch ($page) {
    case "draaitijden":
        $class_name = "draaitijden";
        $table_name = "Draaitijden";
        break;
    case "film":
        $class_name = "film";
        $table_name = "Films";
        break;
    case "kaarten":
        $class_name = "kaarten";
        $table_name = "Kaarten";
        break;
    case "medewerkers":
        $class_name = "medewerkers";
        $table_name = "Medewerkers";
        break;
    case "vestiging":
        $class_name = "vestiging";
        $table_name = "Vestiging";
        break;
    case "zaal":
        $class_name = "zaal";
        $table_name = "Zaal";
        break;
    default:
        echo "Page not found!";
}

if(isset($_GET['id'])){
    //Get 1 record
    $id = $_GET['id'];
    $readDB = new DB();
    //Get data from database {Table_name, class_name, id}
    $records = $readDB->readID($table_name, $class_name, $id);
    echo $records;
}
else
{
    //Get all records
    $readDB = new DB();
    //Get data from database {Table_name, class_name}
    $records = $readDB->read($table_name, $class_name);
    echo $records;
}


?>