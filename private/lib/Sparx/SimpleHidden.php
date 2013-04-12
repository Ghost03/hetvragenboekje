<?php

class Sparx_SimpleHidden extends Zend_Form_Element_Hidden
{
    public function loadDefaultDecorators()
    {
        return $this->addDecorator('ViewHelper');
    }
}