<?php

class Sparx_View_Helper_Quantity extends Zend_Controller_Action_Helper_Abstract {

    public function quantity($id, $max, $current) {
        if ($max > 20)
            $max = 20;

        $html = '<select class=quantity name="quantity-' . $id . '">';
        for ($i = 1; $i <= $max; $i++)
            $html .= '<option' . ($current == $i ? ' selected' : '') . '>' . $i . '</option>';
        $html .= '</select>';
        return $html;
    }

}