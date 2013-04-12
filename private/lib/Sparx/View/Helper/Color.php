<?php

class Sparx_View_Helper_Color extends Zend_Controller_Action_Helper_Abstract {

    private $colors = array();

    public function color($id, $style, $current) {
        if (!$this->colors)
            $this->getColors();
        
        $db = Zend_Registry::get('db');
        $q = $db->prepare('SELECT id,color_id 
                           FROM product 
                           WHERE style = :style');
        $q->bindValue(':style', $style);
        $q->execute();

        $colors = $q->fetchAll(PDO::FETCH_KEY_PAIR);

        $html = '<select class=color name="color-' . $id . '">';
        foreach ($colors as $id => $color_id)
            if(isset($this->colors[$color_id]))
                $html .= '<option value="' . $id . '" ' . ($current == $color_id ? ' selected' : '') . '>' . $this->colors[$color_id] . '</option>';
        $html .= '</select>';
        return $html;
    }

    private function getColors() {
        $db = Zend_Registry::get('db');
        $q = $db->prepare('SELECT color_id,name 
                           FROM color_language 
                           WHERE language_id = :language_id
                           ORDER BY name ASC');
        $q->bindValue(':language_id', Zend_Registry::get('language'));
        $q->execute();

        $this->colors = $q->fetchAll(PDO::FETCH_KEY_PAIR);
    }

}