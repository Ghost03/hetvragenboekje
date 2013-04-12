<?php

class RegisterForm extends Sparx_BaseForm
{    
    public function init()
    {   
        $element = new Sparx_SimpleText('email');
        $element->setRequired(true)
              ->addValidator('EmailAddress');
        $this->addElement($element);   
        
        $element = new Sparx_SimpleText('birth_date');
        $element->setRequired(true)
                ->addFilter('StripTags');
        $this->addElement($element);   
        
        $element = new Sparx_SimpleRadio('gender');
        $element->addValidator(new Zend_Validate_InArray(array('f', 'm')));
        $element->setRequired(true)
                ->addMultiOptions(array(
                    'm' => 'Man',
                    'f' => 'Vrouw',
                ))
                ->setSeparator('')
                ->setValue('m');
        $this->addElement($element);  
        
        $element = new Sparx_SimpleText('cellphone');
        $element->setRequired(true)
                ->addFilter('StripTags');
        $this->addElement($element);         
        
        $element = new Sparx_SimpleText('address');
        $element->setRequired(true)
                ->addFilter('StripTags');
        $this->addElement($element);          
        
        $element = new Sparx_SimpleText('city');
        $element->setRequired(true)
                ->addFilter('StripTags');
        $this->addElement($element);         
        
        $element = new Sparx_SimpleCheck('terms');
        $element->setRequired(true)
                ->setValue(1);
        $this->addElement($element);         
        
        $db = Zend_Registry::get('db');
        $q = $db->prepare('SELECT c.id, cl.name 
                           FROM interest c 
                           LEFT JOIN interest_language cl ON cl.interest_id = c.id 
                           WHERE cl.language_id = :language_id
                           ORDER BY c.position ASC');
        $q->bindValue(':language_id',$this->language);
        $q->execute();
        $interests = $q->fetchAll(PDO::FETCH_KEY_PAIR);
        
        $element = new Sparx_SimpleMultiCheck('interests');
        $element->addMultiOptions($interests)
                ->setSeparator('');
        $this->addElement($element);  
    }
}
