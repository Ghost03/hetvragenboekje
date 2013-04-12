<?php

/**
 * Clock
 * 
 * @author Frank Broersen
 */
class Sparx_View_Helper_Clock extends Zend_View_Helper_Abstract {
    
    public function clock($time) 
    {
        
        return '<div class=d' . $time[0] . '></div>' . 
               '<div class=d' . $time[1] . '></div>' . 
               '<div class=dot></div>' . 
               '<div class=d' . $time[3] . '></div>' . 
               '<div class=d' . $time[4] . '></div>'; 
    }
    
}