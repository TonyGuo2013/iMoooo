<?php
date_default_timezone_set('Asia/Shanghai');

error_reporting(E_ALL & ~E_NOTICE);

define('APPLICATION_PATH', realpath(dirname(__FILE__)));

Yaf_Loader::import(APPLICATION_PATH.'/application/configs/SystemConfig.php');

$application = new Yaf_Application( APPLICATION_PATH . "/application/configs/application.ini");

$application->bootstrap()->run();
?>
