<?php

include_once '../config/includes.php';

class DB
{
    // Get all values from the table
    /**
     * @param $table_name
     * @param $class_name
     * @return string
     */
    function read($table_name, $class_name){

        // instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();

        // select all query
        $query = "SELECT * FROM " . $table_name;

        // prepare query statement
        $stmt = $db->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num>0){

            // array that holds the classes generated from the database data
            $classes_array=array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $class = new $class_name($row);
                $classes_array[] = $class;
            }

            //Encode the data array of classes to json
            $json =  json_encode($classes_array);
        }

        return $json;
    }

    // Get the values for a single ID
    /**
     * @param $table_name
     * @param $class_name
     * @param $id
     * @return string
     */
    function readID($table_name, $class_name, $id){

        // instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();

        // select all from ID query
        $query = "SELECT * FROM " . $table_name . " WHERE ID = " . $id;

        // prepare query statement
        $stmt = $db->prepare($query);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();

        if($num > 0){

            // products array
            $classes_array=array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $class = new $class_name($row);
                $classes_array[] = $class;
            }

            //Encode the data array of classes to json
            $json =  json_encode($classes_array);
        }
        else
        {
            $json = json_encode(
                array("message" => "No records found for " . $table_name . " with the 'id' of " . $id)
            );
        }
        return $json;
    }

    /**
     * @param $table_name
     * @param $class_name
     * @return string
     */
    function create($table_name, $class_name, $object){
        // instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        //create a new class to hold the data
        $class = new $class_name;

        // Loop throught the object data and store it into the arrays
        // Using the class for it's key fields
        $keys = array();
        $values = array();
        foreach($object as $key => $value)
        {
            $keys[] = "`{$key}`";
            $values[] = $class->{$key} = "'{$value}'";
        }

        // Create insert query with the key value pairs
        $query = "INSERT INTO " . $table_name . " (" . implode(",", $keys) . ") 
          VALUES (" . implode(",", $values) . ");";

        // prepare query statement
        $stmt = $db->prepare($query);

        // execute query
        $stmt->execute();
        // Display a message based on succes or failure
        if($stmt){
            return true;
        }
        else{
            return false;
        }

    }

    function edit($table_name, $class_name, $object, $id){
        // instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        //create a new class to hold the data
        $class = new $class_name;

        // Create insert query with the key value pairs
        $query = "UPDATE " . $table_name ." SET";
        //set the first comma to be a space instead
        $comma = " ";
        foreach($object as $key => $value) {
            if( ! empty($value)) {
                if($key != "ID"){
                    $query .= $comma . $key . " = '" . $value . "'";
                    $comma = ", ";
                }
            }
        }
        $query .= " WHERE ID = " . $id;

        // prepare query statement
        $stmt = $db->prepare($query);

        // execute query
        $stmt->execute();
        // Display a message based on succes or failure
        if($stmt){
            return true;
        }
        else{
            return false;
        }
    }

    function delete($table_name, $class_name, $id){

    }
}
?>