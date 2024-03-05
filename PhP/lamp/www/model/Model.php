<?php

/**
 * Base model class from which all specific models will inherit
 */
class Model {

    /**
     * Constructor, from an associative array
     */
    public function __construct(Array $properties=array()){
        foreach($properties as $key => $value){
          $this->{$key} = $value;
        }
    }
}

?>