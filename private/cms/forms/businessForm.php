<?php

class BusinessForm extends Sparx_BaseForm
{
    private $id = false;
    
    public function __construct($id = 0)
    {                
        $this->id = $id;
        
        parent::__construct();
    }
    
    public function init()
    {   
        $db = Zend_Registry::get('db');
                
        /*
         * business select
         */
        $q = $db->prepare('SELECT c.id, cl.name 
                                  FROM business c 
                                  LEFT JOIN business_language cl ON cl.business_id = c.id 
                                  WHERE cl.language_id = :language_id
                                  AND (c.business_id IS NULL OR c.business_id = 0)
                                  AND c.id != :id');
        $q->bindValue(':language_id',$this->language);
        $q->bindValue(':id',$this->id);
        $q->execute();        
        $businesss = $q->fetchAll(PDO::FETCH_KEY_PAIR);
                                
        $element = new Sparx_SimpleSelect('business_id');
        $element->setShort()
                ->addMultiOption(false,'-- No parent business --')
                ->addMultiOptions($businesss);
        $this->addElement($element);
        
        $businesss = null;
        
        $element = new Sparx_SimpleText('image');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleCheck('show_menu');
        $this->addElement($element);
        
        foreach( $this->languages as $language ) {
            $form = new businessLanguageForm();
            $form->setElementsBelongTo($language->code);
            $this->addSubForm($form,$language->name);
        }
    }
}