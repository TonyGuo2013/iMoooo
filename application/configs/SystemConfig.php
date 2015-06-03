<?php

date_default_timezone_set('Asia/Shanghai');

defined('ERROR_LOG_FILE') || define('ERROR_LOG_FILE', 'error');

defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__DIR__).'/../'));
defined('LIB_PATH') || define('LIB_PATH', realpath(APPLICATION_PATH . '/application/library'));
class SystemConfig
{
    public static function  init()
    {
            $configurePath = sprintf('%s/application/configs/config.ini', APPLICATION_PATH);
            $config = new Yaf_Config_Ini($configurePath, 'databases');
            Yaf_Registry::set('dbconfig', $config);
            SystemConfig::loadEssentials();
    }
    public static function loadEssentials()
    {
        Yaf_Loader::import(sprintf('%s/yaf/LocalAutoLoader.php', LIB_PATH));
        Yaf_Loader::import(sprintf('%s/yaf/YafController.php', LIB_PATH));
        Yaf_Loader::import(sprintf('%s/yaf/YafDebug.php', LIB_PATH));
        Yaf_Loader::import(sprintf('%s/yaf/YafView.php', LIB_PATH));
        Yaf_Loader::import(sprintf('%s/halo/HaloModel.php',LIB_PATH));
        LocalAutoLoader::register();
    }
}

SystemConfig::init();

