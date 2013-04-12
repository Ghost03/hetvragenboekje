<?php

class TranslateForm extends Sparx_BaseForm
{
    private $id = false;
    
    public function __construct($id = 0)
    {                
        $this->id = $id;
        
        parent::__construct();
    }
    
    public function init()
    {   
        //
        
        foreach( $this->languages as $language ) {
            $form = new translateLanguageForm();
            $form->setElementsBelongTo($language->code);
            $this->addSubForm($form,$language->name);
        }
    }
}