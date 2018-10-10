<?php

class Medewerker extends ClassConstructor
{
    // database connection and table name
    private $table_name = "Medewerkers";

    // object properties
    public $ID;
    public $vestigingID;
    public $Voorletter;
    public $Achternaam;
    public $Geboortedatum;
    public $Woonplaats;
    public $Email;
    public $Mobiel;

}