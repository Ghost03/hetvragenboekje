<?php

class AntwoordenForm extends Sparx_BaseForm
{
    
    public function init()
    {   
        $element = new Sparx_SimpleTextarea('name');
        $element->setRequired();
        $this->addElement($element);
    }
}