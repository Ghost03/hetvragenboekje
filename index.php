<?php
if($_GET['debug'] == 'phpinfo')
{
	phpinfo();
	exit();
}
define('DOCROOT',dirname(__FILE__) . '/');

require 'private/app/bootstrap.php';