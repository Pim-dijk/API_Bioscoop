<?php

class permissions extends ClassConstructor{

    // database connection and table name
    private $table_name = "permissions";

    // object properties
    public $Id;
    public $origin;
    public $level;
}