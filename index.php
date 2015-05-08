<?php

define('APPLICATION_PATH', realpath(dirname(__FILE__)));

Yaf_Loader::import(APPLICATION_PATH.'/application/configs/SystemConfig.php');

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>
