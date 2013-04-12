<?php

class Sparx_SimpleSelect extends Zend_Form_Element_Select
{
    public function init()
    {
        $this->setAttrib('class', 'select');
        
        $this->getView()->addHelperPath('Sparx/View/Helper', 'Sparx_View_Helper');
    }
    
    public function setShort()
    {
        return $this->setAttrib('class', $this->getAttrib('class') . ' small-input');
    }
    
    public function setMedium()
    {
        return $this->setAttrib('class', $this->getAttrib('class') . ' medium-input');
    }
    
    public function setLong()
    {
        return $this->setAttrib('class', $this->getAttrib('class') . ' long-input');
    }
    
    public function loadDefaultDecorators()
    {
        return $this->addDecorator('ViewHelper');
    }
}