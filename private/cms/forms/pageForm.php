<?php

class PageForm extends Sparx_BaseForm
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
         * Page select
         */
        $q = $db->prepare('SELECT c.id, cl.name 
                                  FROM page c 
                                  LEFT JOIN page_language cl ON cl.page_id = c.id 
                                  WHERE cl.language_id = :language_id
                                  AND (c.page_id IS NULL OR c.page_id = 0)
                                  AND c.id != :id');
        $q->bindValue(':language_id',$this->language);
        $q->bindValue(':id',$this->id);
        $q->execute();        
        $pages = $q->fetchAll(PDO::FETCH_KEY_PAIR);
                                
        $element = new Sparx_SimpleSelect('page_id');
        $element->setShort()
                ->addMultiOption(false,'-- No parent page --')
                ->addMultiOptions($pages);
        $this->addElement($element);
        
        $pages = null;
        
        
        $element = new Sparx_SimpleSelect('module');
        $element->setShort()
                ->addMultiOption(false,'-- No module --');
        $this->addElement($element);
        
        $config = Zend_Registry::get('config');
        $modules = $config->modules;
        
        $modules = array(
            array(1, 'news'), 
            array(2, 'cases'), 
            array(3, 'contact'));
        
        $_modules = array();
        
        foreach ($modules as $i => $module)
        {
            $element->addMultiOption($module[0], $module[1]);
        }
        
        $element = new Sparx_SimpleCheck('menu');
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('redirect');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('image');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleCheck('footer');
        $this->addElement($element);
        
        $element = new Sparx_SimpleCheck('noindex');
        $this->addElement($element);
        
        foreach( $this->languages as $language ) {
            $form = new pageLanguageForm();
            $form->setElementsBelongTo($language->code);
            $this->addSubForm($form,$language->name);
        }
    }
}