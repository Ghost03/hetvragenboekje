<?php

class NewsLanguageForm extends Sparx_BaseForm
{
    public function init()
    {
        $element = new Sparx_SimpleText('title');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleSelect('status');
        $element->setShort()
                ->addMultiOption('0','Disable')
                ->addMultiOption('1','Show');
        $this->addElement($element);
        
        $element = new Sparx_SimpleTextarea('short');
        $this->addElement($element);
        
        $element = new Sparx_SimpleTextarea('intro');
        $this->addElement($element);
        
        $element = new Sparx_SimpleTextarea('content');
        $this->addElement($element);
    }
}