<?php

class Sparx_View_Helper_Colorpicker extends Zend_Controller_Action_Helper_Abstract {

    private $colors = array();

    public function colorpicker($style) {
        if (!$this->colors)
            $this->getColors();
        
        $request = $this->getRequest();
        $view = Zend_Layout::getMvcInstance()->getView();
        
        $db = Zend_Registry::get('db');
        $q = $db->prepare('SELECT p.id,p.color_id, pl.url
                           FROM product p
                           LEFT JOIN product_language pl
                             ON p.id = pl.product_id 
                           WHERE p.style = :style');
        $q->bindValue(':style', $style);
        $q->execute();

        $colors = $q->fetchAll(PDO::FETCH_ASSOC);

        $html = '<div class=colorpicker>';
        foreach ($colors as $data)
            if(isset($this->colors[$data['color_id']]))
                $html .= '<a href="' . $view->url( array( 'url' => $data['url'] ), 'product-detail' ) . '" rel="' . $data['id'] . '"><img src="' . $this->colors[$data['color_id']] . '" /></a>';
        $html .= '</div>';
        return $html;
    }

    private function getColors() {
        $db = Zend_Registry::get('db');
        $q = $db->prepare('SELECT id,image 
                           FROM color
                           ORDER BY id ASC');
        $q->bindValue(':language_id', Zend_Registry::get('language'));
        $q->execute();

        $this->colors = $q->fetchAll(PDO::FETCH_KEY_PAIR);
    }

}