<?php

class Draaitijden extends ClassConstructor
{
    // database connection and table name
    private $table_name = "Draaitijden";

    // object properties
    public $ID;
    public $filmID;
    public $zaalID;
    public $Tijd;
    public $Datum;
}