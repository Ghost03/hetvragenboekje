<?php

class Sparx_SimplePassword extends Zend_Form_Element_Password
{
    public $renderPassword = true;
    
    public function init()
    {
        $this->setAttrib('class', 'password text-input')
             ->addFilter('StringTrim');
        
        $this->getView()->addHelperPath('Sparx/View/Helper', 'Sparx_View_Helper');
    }
    
    public function loadDefaultDecorators()
    {
        return $this->addDecorator('ViewHelper')
                    ->addDecorator('Errors');
    }
}