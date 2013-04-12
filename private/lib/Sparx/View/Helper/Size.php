<?php

class Sparx_View_Helper_Size extends Zend_Controller_Action_Helper_Abstract {

    private $sizes = array();

    public function size($id, $size_id, $current = false) {
        if (!$this->sizes)
            $this->getSizes();
        
        $db = Zend_Registry::get('db');
        $q = $db->prepare('SELECT size_id,id 
                           FROM product_size 
                           WHERE product_id = :id
                           AND stock > 0');
        $q->bindValue(':id', $size_id);
        $q->execute();
        
        $sizes = $q->fetchAll(PDO::FETCH_KEY_PAIR);
                             
        $html = '<select class=size name="size-' . $id . '">';
        foreach ($sizes as $size_id => $id)
            if(isset($this->sizes[$size_id]))
                $html .= '<option value="' . $id . '" ' . ($current == $size_id ? ' selected' : '') . '>' . $this->sizes[$size_id] . '</option>';
        $html .= '</select>';
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