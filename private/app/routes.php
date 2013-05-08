<?php

return array(
    
    // PAGES ROUTING
    
    'home' => new Zend_Controller_Router_Route('/', array('controller' => 'page','action' => 'home')),
    'categorieen' => new Zend_Controller_Router_Route('categorieen', array('controller' => 'categorieen', 'action' => 'list')),
    'categorie' => new Zend_Controller_Router_Route('categorieen/:categorie', array('controller' => 'categorieen', 'action' => 'detail')),
    'zoeken' => new Zend_Controller_Router_Route('zoeken', array('controller' => 'search', 'action' => 'results')),
    'zoeken-meer' => new Zend_Controller_Router_Route('zoeken-meer', array('controller' => 'search', 'action' => 'getresults')),
    'profiel' => new Zend_Controller_Router_Route('profiel', array('controller' => 'profile', 'action' => 'edit')),

    'inloggen' => new Zend_Controller_Router_Route('inloggen', array('controller' => 'login', 'action' => 'index')),
    'checklogin' => new Zend_Controller_Router_Route('checklogin', array('controller' => 'login', 'action' => 'checkemail')),
    'uitloggen' => new Zend_Controller_Router_Route('uitloggen', array('controller' => 'user', 'action' => 'logout')),
    'registreren' => new Zend_Controller_Router_Route('registreren', array('controller' => 'register', 'action' => 'index')),
   

    'questions' => new Zend_Controller_Router_Route('questions', array('controller' => 'questions', 'action' => 'overview')),
    'question' => new Zend_Controller_Router_Route('question/:question', array('controller' => 'questions', 'action' => 'detail')),
    'steleenvraag' => new Zend_Controller_Router_Route('steleenvraag', array('controller' => 'ask', 'action' => 'index')),
    'antwoord' => new Zend_Controller_Router_Route('antwoord', array('controller' => 'questions', 'action' => 'detail')),
    'printpdf' => new Zend_Controller_Router_Route('printpdf', array('controller' => 'questions', 'action' => 'generatehtml')),
    'createpdf' => new Zend_Controller_Router_Route('createpdf', array('controller' => 'questions', 'action' => 'createpdf')),
);