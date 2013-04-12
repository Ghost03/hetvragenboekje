<?php

class Sparx_SimpleCheck extends Zend_Form_Element_Checkbox
{
    public function loadDefaultDecorators()
    {
        return $this->addDecorator('ViewHelper');
    }
        
    public function addClass($class)
    {
        return $this->setAttrib('class', $this->getAttrib('class') . ' ' . $class);
    }
}