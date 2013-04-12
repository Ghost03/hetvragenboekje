<?php

class Sparx_SimpleRadio extends Zend_Form_Element_Radio
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