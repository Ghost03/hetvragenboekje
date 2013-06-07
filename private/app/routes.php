<?php

return array(
    
    // PAGES ROUTING
    
    'home' => new Zend_Controller_Router_Route('/', array('controller' => 'index','action' => 'home')),
    'categorieen' => new Zend_Controller_Router_Route('categorieen', array('controller' => 'categorieen', 'action' => 'list')),
    'categorie' => new Zend_Controller_Router_Route('categorieen/:categorie', array('controller' => 'categorieen', 'action' => 'detail')),
    'zoeken' => new Zend_Controller_Router_Route('zoeken', array('controller' => 'search', 'action' => 'results')),
    'zoeken-meer' => new Zend_Controller_Router_Route('zoeken-meer', array('controller' => 'search', 'action' => 'getresults')),
    'profiel' => new Zend_Controller_Router_Route('profiel', array('controller' => 'profile', 'action' => 'edit')),

    'checklogin' => new Zend_Controller_Router_Route('checklogin', array('controller' => 'login', 'action' => 'checkemail')),
    'uitloggen' => new Zend_Controller_Router_Route('uitloggen', array('controller' => 'user', 'action' => 'logout')),
    'registreren' => new Zend_Controller_Router_Route('registreren', array('controller' => 'register', 'action' => 'index')),

    'questions' => new Zend_Controller_Router_Route('questions', array('controller' => 'questions', 'action' => 'overview')),
    'question' => new Zend_Controller_Router_Route('question/:question', array('controller' => 'questions', 'action' => 'detail')),
    'steleenvraag' => new Zend_Controller_Router_Route('steleenvraag', array('controller' => 'ask', 'action' => 'index')),
    'antwoord' => new Zend_Controller_Router_Route('antwoord', array('controller' => 'questions', 'action' => 'detail')),
    'printpdf' => new Zend_Controller_Router_Route('printpdf', array('controller' => 'questions', 'action' => 'generatehtml')),
    'createpdf' => new Zend_Controller_Router_Route('createpdf', array('controller' => 'questions', 'action' => 'createpdf')),

    'wachtwoord-vergeten' => new Zend_Controller_Router_Route('wachtwoord-vergeten', array('controller' => 'login', 'action' => 'forgotpassword')),
    'reset' => new Zend_Controller_Router_Route('reset', array('controller' => 'login', 'action' => 'reset')),
    'resetpassword' => new Zend_Controller_Router_Route('resetpassword', array('controller' => 'login', 'action' => 'resetpassword')),

    'photo' => new Zend_Controller_Router_Route('photo', array('controller' => 'profile', 'action' => 'photo')),
    'check-exists' => new Zend_Controller_Router_Route('check-exists', array('controller' => 'profile', 'action' => 'checkexists')),

    'thumbsup' => new Zend_Controller_Router_Route('thumbsup', array('controller' => 'answer', 'action' => 'thumbsup')),
    'tag' => new Zend_Controller_Router_Route('tag/:tag', array('controller' => 'tag', 'action' => 'detail')),

    'contact' => new Zend_Controller_Router_Route('contact', array('controller' => 'contact', 'action' => 'overview'))
);