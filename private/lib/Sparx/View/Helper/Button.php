<?php

/**
 * Button view helper
 * 
 * @author Frank Broersen
 */
class Sparx_View_Helper_Button extends Zend_View_Helper_Abstract {

    private $button;
    private $id;
    private $target;
    private $parent;
    
    /**
     * Add 1 or more url | title pairs to the breadcrumb
     * @return Sparx_View_Helper_buttons 
     */
    public function button($button,$id,$target,$parent) {
        $this->target = $target;
        $this->parent = $parent;
        $this->button = $button;
        $this->id = $id;
        return $this;
    }

    /**
     * Compile and output the breadcrumb
     * @return string
     */
    public function __toString() {    
        $button = $this->button;
        $attributes = array();
        if(isset($button['url']))  $attributes[]  = "data-url='{$button['url']}'";
        if(isset($button['type'])) $attributes[]  = "data-type='{$button['type']}'";
        if(isset($button['related'])) $attributes[]  = "data-related='{$button['related']}'";
        
        $active = isset($button['active']) && $button['active'] == 1 ? 'active ' : '';
        $href   = isset($button['href'])   ? 'href="' . $button['href'] . '" ' : '';
        $rel    = isset($button['rel'])    ? $button['rel'] : 'ajax';
        
        return '<a ' . $href . ' data-target="#' . $this->target . '-' . $this->id . '" ' . implode(' ',$attributes) . ' data-parent="#' . $this->parent . '" rel="' . $rel . '" class="' . $active . 'button floatleft">' . $button['text'] . '</a>' . PHP_EOL;
    }

}