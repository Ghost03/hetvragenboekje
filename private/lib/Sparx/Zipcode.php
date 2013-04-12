<?php

/**
 * Sparx_Zipcode
 * Writte for the Graydon search database
 *  
 */
class Sparx_Zipcode implements Zend_Filter_Interface {

    /**
     * Filters a zipcode
     * Add a space between the digits and alpha characters
     */
    public function filter($value) {
        if(strlen($value) == 6)
            return substr($value,0,4) . ' ' . substr($value,4,2);
        return $value;
    }

}

