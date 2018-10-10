<?php

class ClassConstructor
{
    // constructor with $db as database connection
    public function __construct(Array $properties=array()){
        foreach($properties as $key => $value)
        {
            $this->{$key} = $value;
        }
    }
}