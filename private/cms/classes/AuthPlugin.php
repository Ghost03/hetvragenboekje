<?php

class AuthPlugin extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if($request->getControllerName() == 'user' && $request->getActionName() == 'login')
            return;
        
        $user = new Zend_Session_Namespace('cmsuser');
        if(!isset($user->id)) {
            
            $mode = strtolower(MODE);
            
            $config = Zend_Registry::get('config');
            header('Location: ' . $config->baseurl . $mode . '/user/login?from=' . substr($_SERVER['REQUEST_URI'],strpos($_SERVER['REQUEST_URI'], $mode .'/') + strlen($mode)));        
        }
    }
}