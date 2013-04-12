<?php

class Sparx_View_Helper_Banner extends Zend_Controller_Action_Helper_Abstract {

    private $today = false;
    
    public function banner($poule = 'FOOTER') {
        
        if(!$this->today) $this->today = date('Y-m-d',strtotime('Today'));
        
        $db = Zend_Registry::get('db');
        $q = $db->prepare('SELECT html
                           FROM banner 
                           WHERE poule = :poule
                           AND date_start != \'0000-00-00\'
                           AND date_start <= :today
                           AND (date_end > :today OR date_end = \'0000-00-00\')
                           ORDER BY RAND()
                           LIMIT 1');
        $q->bindValue(':poule', $poule);
        $q->bindValue(':today', $this->today);
        $q->execute();
         
        return $q->fetchColumn();
    }

}