<?php

class HomepageForm extends Sparx_BaseForm
{
    
    public function init()
    {   
        $db = Zend_Registry::get('db');
        
        foreach( $this->languages as $language ) {
            $form = new homepageLanguageForm();
            $form->setElementsBelongTo($language->code);
            $this->addSubForm($form,$language->name);
        }
    }
}