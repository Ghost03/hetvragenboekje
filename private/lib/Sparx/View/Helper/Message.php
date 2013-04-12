<?php

class Sparx_View_Helper_Message extends Zend_Controller_Action_Helper_Abstract {

    public function message($content,$type = 'error') {
        return '<div class="alert-message block-message ' . $type . '">
                    <p>' . $content . '</p>
                </div>';
    }

}