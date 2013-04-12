<?php

define('APP_START',microtime(true));


/*
 * Zend Application
 */

define('APP_PATH',  dirname(__FILE__) . '/');
define('CONTROLLERS_PATH',  APP_PATH . '/controllers/');
define('LIB_PATH',  APP_PATH . '../lib/');
define('FORM_PATH', APP_PATH . 'forms/');
define('MODEL_PATH',  APP_PATH . 'models/');

require_once LIB_PATH . 'utils.php';

set_include_path(LIB_PATH  . PATH_SEPARATOR .
                 CONTROLLERS_PATH . PATH_SEPARATOR .
                 FORM_PATH . PATH_SEPARATOR .
                 MODEL_PATH . PATH_SEPARATOR .
                 get_include_path());

require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
$loader->setFallbackAutoloader(true);

$front = Zend_Controller_Front::getInstance();
$front->setControllerDirectory(CONTROLLERS_PATH);

#$front->setControllerDirectory(CONTROLLERS_PATH);
if(defined('DEVELOPMENT') || isset($_GET['debug']) && $_GET['debug'] == $config['debug'])
    $front->throwExceptions(true);

/*
 * Config
 */
$config = new Zend_Config_Json(APP_PATH . '../config.json');
Zend_Registry::set('config',$config);

/*
 * Locale
 */
$locale = new Zend_Locale('en_EN');
Zend_Registry::set('locale',$locale);
date_default_timezone_set('Europe/Amsterdam');

/*
 * Cachine
 */
/*$frontend = array('lifetime' => 0,'automatic_serialization'=>true);
$backend  = array('cache_dir' => dirname(__FILE__).'/../cache/');
$cache_0  = Zend_Cache::factory('core','File',$frontend,$backend);
Zend_Registry::set('cache-infinite',$cache_0);

$frontend= array('lifetime' => 6000,'automatic_serialization'=>true);
$backend = array('cache_dir' => dirname(__FILE__).'/../cache/');
$cache = Zend_Cache::factory('core','File',$frontend,$backend);
Zend_Registry::set('cache',$cache);*/

/*
 * Language
 */
#Zend_Translate::setCache($cache);
$translate = new Zend_Translate(
    array(
        'adapter' => 'gettext',
        'content' => APP_PATH . 'languages/default.mo',
        'locale'  => $locale
    )
);
Zend_Registry::set('Zend_Translate', $translate);
Zend_Form::setDefaultTranslator($translate);
 
// to clear the cache somewhere later in your code
#Zend_Translate::clearCache();

/*
 * Routing
 */
$router = $front->getRouter();
$router->removeDefaultRoutes();
$router->addRoutes(require('routes.php'));

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
 * Launch
 */

ob_start();
$front->dispatch();
