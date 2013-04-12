<?php

class Sparx_SimpleMultiCheck extends Zend_Form_Element_MultiCheckbox
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