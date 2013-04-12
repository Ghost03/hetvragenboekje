<?php

class Sparx_View_Helper_FormErrors extends Zend_View_Helper_FormErrors {

    public function formErrors($errors, array $options = null) 
    {        
        $this->setElementStart('<span class=help-inline>');
        $this->setElementSeparator('<br/>'.PHP_EOL);
        $this->setElementEnd('</span>');
        
        return parent::formErrors($errors, $options);
    }

}