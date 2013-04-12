<?php

class Sparx_View_Helper_Page extends Zend_View_Helper_Abstract {
    
    public function page($url)
    {        
        $db = Zend_Registry::get('db');
        
        $q = $db->prepare('SELECT cl.*, c.colorscheme_id, c.background     
                                 FROM page c 
                                 LEFT JOIN page_language cl ON cl.page_id = c.id 
                                 WHERE cl.language_id = :language_id
                                 AND cl.url = :url   
                                 LIMIT 1');
        $q->bindValue(':language_id',Zend_Registry::get('language'));
        $q->bindValue(':url',$url);
        $q->execute();
        
        $page = $q->fetch(PDO::FETCH_ASSOC);
        
        if(!$page) return false;
        
        if($page['colorscheme_id'] || $page['background'])
            $this->view->skin = $this->view->skin($page['colorscheme_id'],$page['background']);
        if($page['title'])
            $this->view->headTitle($page['title']);
        if($page['description'])
            $this->view->headMeta($page['description'],'description');
        if($page['keywords']) 
            $this->view->headMeta($page['keywords'],'keywords');
        
        return $page;        
    }
    
}