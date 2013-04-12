<?php

class SlidesForm extends Sparx_BaseForm
{
    
    public function init()
    {   
        $element = new Sparx_SimpleText('title');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('text');
        $element->setShort();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('image');
        $element->setMedium();
        $this->addElement($element);
    }
}