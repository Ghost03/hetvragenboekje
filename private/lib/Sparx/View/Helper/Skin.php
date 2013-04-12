<?php

class Sparx_View_Helper_Skin extends Zend_Controller_Action_Helper_Abstract {

    public function skin($id,$background = false) {
                
        $db = Zend_Registry::get('db');
                
        $q = $db->prepare('SELECT data,url
                                 FROM colorscheme
                                 WHERE id = :id
                                 LIMIT 1');
        $q->bindValue(':id',$id);
        $q->execute();
        
        $skin = $q->fetch(PDO::FETCH_ASSOC);
        
        if(!$skin) return array(
            'url' => 'default',
            'data' => array('background'=>$background ? $background : '')
        );
        
        $data = json_decode($skin['data'],1);
        
        if($background && $background != '')
            $data['background'] = $background;
        
        return array(
            'data'  => $data,
            'url'   => $skin['url']
        );
    }

}