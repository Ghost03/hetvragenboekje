<?php

class CategorieenForm extends Sparx_BaseForm
{
    
    public function init()
    {   
        $element = new Sparx_SimpleText('name');
        $element->setRequired()
        		->setMedium();
        $this->addElement($element);
    }
}