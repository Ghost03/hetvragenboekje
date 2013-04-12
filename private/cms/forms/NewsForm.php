<?php

class NewsForm extends Sparx_BaseForm
{
    
    public function init()
    {   
        $db = Zend_Registry::get('db');

        $element = new Sparx_SimpleText('title');
        $element->setMedium()
                ->setRequired();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('date_created');
        $element->setShort()
                ->setRequired();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('image');
        $element->setMedium();
        $this->addElement($element);

        $element = new Sparx_SimpleTextarea('text');
        $this->addElement($element);

        $element = new Sparx_SimpleText('author');
        $element->setMedium();
        $this->addElement($element);
    }
}