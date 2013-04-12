<?php

class Sparx_Colorscheme extends Sparx_SimpleSelect {
    
    public function __construct($name)
    {
        parent::__construct($name);
        
        $db = Zend_Registry::get('db');
        /*
         * Color scheme select
         */
        $q = $db->prepare('SELECT id, name 
                                  FROM colorscheme 
                                  ORDER BY name ASC');
        $q->execute();        
        $schemes = $q->fetchAll(PDO::FETCH_KEY_PAIR);
                                
        //$element = new Sparx_SimpleSelect('colorscheme_id');
        $this->setShort()
                ->addMultiOption(false,'-- Default color scheme --')
                ->addMultiOptions($schemes);
        
        return $this;
    }
    
}