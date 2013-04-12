<?php

class Sparx_View_Helper_Sizepicker extends Zend_Controller_Action_Helper_Abstract {

    private $sizes = array();

    public function sizepicker($product_id, $current = false) {
        if (!$this->sizes)
            $this->getSizes();
        
        $request = $this->getRequest();
        $view = Zend_Layout::getMvcInstance()->getView();
        
        $db = Zend_Registry::get('db');
        $q = $db->prepare('SELECT size_id,id 
                           FROM product_size 
                           WHERE product_id = :product_id
                           AND stock > 0');
        $q->bindValue(':product_id', $product_id);
        $q->execute();
        
        $sizes = $q->fetchAll(PDO::FETCH_KEY_PAIR);
                             
        $html = '<div class=sizepicker>';
        foreach ($sizes as $size_id => $id)
            if(isset($this->sizes[$size_id]))
                $html .= '<a href="' . $view->url( array( 'url' => $request->getParam('url'), 'size_id' => $size_id ), 'product-detail' ) . '" rel="' . $id . '" ' . ($current == $size_id ? ' class="active"' : '') . '>' . $this->sizes[$size_id] . '</a>';
        $html .= '</div>';
        return $html;
    }

    private function getSizes() {
        $db = Zend_Registry::get('db');
        $q = $db->prepare('SELECT size_id,name 
                           FROM size_language 
                           WHERE language_id = :language_id
                           ORDER BY name ASC');
        $q->bindValue(':language_id', Zend_Registry::get('language'));
        $q->execute();

        $this->sizes = $q->fetchAll(PDO::FETCH_KEY_PAIR);
    }

}