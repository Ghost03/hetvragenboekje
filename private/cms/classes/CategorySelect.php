<?php

class CategorySelect extends Sparx_SimpleSelect {
    
    public static $_options = false;
    
    public static $_disabled = false;
    
    public function init() {
        
        parent::init();
        
        $disabled = array();
        
        $this->setMedium();
        
        if(self::$_options) {
            $this->addMultiOptions(self::$_options);
            $this->setAttrib("disable", self::$_disabled);
            return;
        }
        
        $categories = array(
            1 => 'Cases',
            2 => 'News',
            3 => 'Testimonials',
            4 => 'Team',
            5 => 'Remaining'
        );
        
        $types = array(
            1 => 'Images',
            2 => 'Videos',
            3 => 'Documents'
        );
        
        $db = Zend_Registry::get('db');
        
        // Cases ophalen uit DB.
        $q = $db->prepare('SELECT id, name, sort
                           FROM library_categories 
                           ORDER BY sort, name');
        $q->execute();
        $_categories = $q->fetchAll(PDO::FETCH_ASSOC);
        
        
        foreach($categories as $category_id => $name) {
            
            $disabled[] = 'c-' . $category_id;
            $this->addMultiOption('c-'.$category_id,$name);
            $category = '';
            
           
            foreach($_categories as $i => $file) {
                if($file['sort'] != $category_id) continue;
                $category = $file['sort'];
                $this->addMultiOption($file['id'],'- '.$file['name']);

            }
                
        }
        
        $this->setAttrib("disable", $disabled);
        
        self::$_options = $this->getMultiOptions();
        self::$_disabled = $disabled;
    }
    
}