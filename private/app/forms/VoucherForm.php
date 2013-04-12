<?php

class VoucherForm extends Sparx_BaseForm
{    
    public function __construct()
    {                
        $element = new Sparx_SimpleText('code');
        $element->setRequired(true);
        $this->addElement($element);
    }
}
