<?php


return array(
	'controller/action' => new Zend_Controller_Router_Route(':controller/:action/:parameters', array('controller' => 'dashboard', 'action' => 'home', 'parameters'=>'')),
);