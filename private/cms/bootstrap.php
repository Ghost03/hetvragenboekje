<?php

if(isset($_POST['SESSION_ID'])) session_id($_POST['SESSION_ID']);

define('APP_PATH',  dirname(__FILE__) . '/');
define('CONTROLLERS_PATH',  APP_PATH . '/controllers/');
define('LIB_PATH',  APP_PATH . '../lib/');
define('FORM_PATH', APP_PATH . 'forms/');
define('CLASS_PATH', APP_PATH . 'classes/');

require_once LIB_PATH . 'utils.php';

set_include_path(LIB_PATH  . PATH_SEPARATOR .
                 CONTROLLERS_PATH . PATH_SEPARATOR .
                 FORM_PATH . PATH_SEPARATOR .
                 CLASS_PATH . PATH_SEPARATOR);
                 
/*HP 5.3 OpenBase DIR temporary fix lan (GET INCLUDE PATH ERUIT HALEN): set_include_path(LIB_PATH  . PATH_SEPARATOR .
                 CONTROLLERS_PATH . PATH_SEPARATOR .
                 FORM_PATH . PATH_SEPARATOR .
                 CLASS_PATH . PATH_SEPARATOR .
                 get_include_path());*/

require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
$loader->setFallbackAutoloader(true);

$front = Zend_Controller_Front::getInstance();
$front->setControllerDirectory(CONTROLLERS_PATH);

$front->registerPlugin(new AuthPlugin);

#$front->setControllerDirectory(CONTROLLERS_PATH);
#if(defined('DEVELOPMENT') || isset($_GET['debug']) && $_GET['debug'] == $config['debug'])
    $front->throwExceptions(true);

/*
 * Config
 */
$config = new Zend_Config_Json(APP_PATH . '../config.json');
Zend_Registry::set('config',$config);
date_default_timezone_set('Europe/Amsterdam');

/*
 * Cachine
 */
/*
$frontend = array('lifetime' => 0,'automatic_serialization'=>true);
$backend  = array('cache_dir' => dirname(__FILE__).'/../cache/');
$cache_0  = Zend_Cache::factory('core','File',$frontend,$backend);
Zend_Registry::set('cache-infinite',$cache_0);

$frontend= array('lifetime' => 6000,'automatic_serialization'=>true);
$backend = array('cache_dir' => dirname(__FILE__).'/../cache/');
$cache = Zend_Cache::factory('core','File',$frontend,$backend);
Zend_Registry::set('cache',$cache);
/*

/*
 * Language
 */
//Zend_Translate::setCache($cache);
$translate = new Zend_Translate(
    array(
        'adapter' => 'gettext',
        'content' => APP_PATH . 'languages/default.mo',
        'locale'  => 'en'
    )
);

$translate->setLocale('en');
Zend_Registry::set('Zend_Translate',$translate);
Zend_Registry::set('language',1);

// to clear the cache somewhere later in your code
//Zend_Translate::clearCache();

/*
 * Routing
 */
$router = $front->getRouter();
//$router->addRoutes(require(APP_PATH . '../app/routes.php'));

$home = new Zend_Controller_Router_Route_Static('/', array('controller' => 'dashboard', 'action' => 'home','language'=>1));
$front->getRouter()->addRoute('home', $home);
//$router->removeDefaultRoutes();

/*
 * Currency (if we want the shop in USD or GBP)
 */
/*
$currency = new Zend_Currency('nl_NL','EUR');
$currency->setService( new Sparx_Exchange() );
Zend_Currency::setCache($cache);
*/
Zend_Registry::set('currency',$currency);
Zend_Layout::startMvc();

/*
 * Database
 */
try {
    $db = Zend_Db::factory($config->database);
} catch(Exception $e) {
    die('A database error occured: ' . $e->getMessage());
}
Zend_Registry::set('db', $db);

/*
 * Sessions
 */
Zend_Session::start();


/*
 * Pagination
 */
Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

/*
 * 10.
 * 9.
 * 8.
 * 7.
 * 6.
 * 5.
 * 4.
 * 3.
 * 2.
 * 1.
 * Launch
 */
$front->dispatch();
