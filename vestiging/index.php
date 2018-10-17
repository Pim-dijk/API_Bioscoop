<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Method: GET, POST, PUT, DELETE");
header('Content-Type: application/json');

// include database and object files
include_once '../config/includes.php';

$table_name = "Vestiging";
$class_name = "vestiging";

$headers = apache_request_headers();
$auth = new Authentication();

if($auth->validate($headers)){

// The request is using the GET method
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_GET['id'])) {
            //Get 1 record
            $id = $_GET['id'];
            $readDB = new DB();
            //Get data from database {Table_name, class_name, id}
            $records = $readDB->readID($table_name, $class_name, $id);
            echo $records;
        } else {
            //Get all records
            $readDB = new DB();
            //Get data from database {Table_name, class_name}
            $records = $readDB->read($table_name, $class_name);
            echo $records;
        }
    }

// The request is using the POST method
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // get posted data
        $data = json_decode(file_get_contents("php://input"));
        // turn json to array so I can construct a new class object
        $array = (array)$data;

        $db = new DB();
        $model = new $class_name($array);

        //{Table_name, class_name, id}
        $response = $db->create($table_name, $class_name, $model);

        if ($response) {
            echo '{';
            echo '"message": "' . $class_name . ' succesvol toegevoegd."';
            echo '}';
        } else {
            echo '{';
            echo '"message": "' . $class_name . ' is is niet toegevoegd!."';
            echo '}';
        }
    }

// The request is using the PUT method
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        if (!isset($_GET['id'])) {
            echo '{';
            echo '"message": "You need to specify an ID for this to work.<br/> You dummy!"';
            echo '}';
            exit;
        }

        $id = $_GET['id'];

// get posted data
        $data = json_decode(file_get_contents("php://input"));
// turn json to array so I can construct a new class object
        $array = (array)$data;

        $db = new DB();
        $model = new $class_name($array);
// check that the $_GET['id'] matches the id in the object that was send
        if ($id != $model->ID) {
            echo '{';
            echo '"message": "The id of the url does not match the ID in the send data!"';
            echo '}';
            exit;
        }

//{Table_name, class_name, id}
        $response = $db->edit($table_name, $class_name, $model, $id);

        if ($response) {
            echo '{';
            echo '"message": "' . $class_name . ' succesvol bijgewerkt."';
            echo '}';
        } else {
            echo '{';
            echo '"message": "' . $class_name . ' is is niet bijgewerkt!."';
            echo '}';
        }
    }

// The request is using the DELETE method
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        if (!isset($_GET['id'])) {
            echo '{';
            echo '"message": "You need to specify an ID for this to work.<br/> You dummy!"';
            echo '}';
            exit;
        }

        $id = $_GET['id'];

// get posted data
        $data = json_decode(file_get_contents("php://input"));
// turn json to array so I can construct a new class object
        $array = (array)$data;

        $db = new DB();
        $model = new $class_name($array);

// check that the $_GET['id'] matches the id in the object that was send
        if ($id != $model->ID) {
            echo '{';
            echo '"message": "The id of the url does not match the ID in the send data!"';
            echo '}';
            exit;
        }

//{Table_name, id}
        $response = $db->delete($table_name, $id);

        if ($response) {
            echo '{';
            echo '"message": "' . $class_name . ' succesvol verwijderd."';
            echo '}';
        } else {
            echo '{';
            echo '"message": "' . $class_name . ' is is niet verwijderd!."';
            echo '}';
        }
    }
}
