<?php

class ClubsForm extends Sparx_BaseForm
{
    
    public function init()
    {   
        $element = new Sparx_SimpleText('club');
        $element->setMedium()
                ->setRequired();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('tag');
        $element->setMedium()
                ->setRequired();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('captain');
        $element->setMedium()
        		->setRequired();
        $this->addElement($element);
    }
}