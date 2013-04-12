<?php

// @TODO something better can be done ?

class Sparx_View_Helper_Currency extends Zend_Controller_Action_Helper_Abstract {

    public function currency($amount) {
        $currency = Zend_Registry::get('currency');
        $currency->setValue($amount);
        return $currency->toCurrency();
    }

}