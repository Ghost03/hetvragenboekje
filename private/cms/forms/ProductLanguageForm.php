<?php

class ProductLanguageForm extends Sparx_BaseForm
{
    
    public function init()
    {   
        $db = Zend_Registry::get('db');

        $element = new Sparx_SimpleText('name');
        $element->setMedium();
        $this->addElement($element);

        $element = new Sparx_SimpleTextarea('properties');
        $this->addElement($element);

        $element = new Sparx_SimpleTextarea('description');
        $this->addElement($element);

        $element = new Sparx_SimpleSelect('color');
        $element->setShort()
                ->addMultiOption(false,'-- Color --')
                ->addMultiOption('yellow','Yellow')
                ->addMultiOption('orange','Orange')
                ->addMultiOption('red','Red')
                ->addMultiOption('blue','Blue')
                ->addMultiOption('green','Green')
                ->addMultiOption('violet','Violet');
        $this->addElement($element);

        $element = new Sparx_SimpleText('color_index');
        $element->setShort();
        $this->addElement($element);

        $element = new Sparx_SimpleText('product_code');
        $element->setShort();
        $this->addElement($element);

     }
}