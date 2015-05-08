<?php

date_default_timezone_set('Asia/Shanghai');

defined('ERROR_LOG_FILE') || define('ERROR_LOG_FILE', 'error');

defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__DIR__)));
defined('LIB_PATH') || define('LIB_PATH', realpath(APPLICATION_PATH . '/application/library'));
class SystemConfig
{
    public static function  init()
    {
        $_ENV['APP_NAME']=(pathinfo(realpath(APPLICATION_PATH),  PATHINFO_BASENAME ));
        $configurePath = sprintf('%s/config/config.ini', APPLICATION_PATH);
        $config = new Yaf_Config_Ini($configurePath, 'production');
        Yaf_Registry::set('config', $config);
        SystemConfig::loadEssentials();
    }
    public static function loadEssentials()
    {
        Yaf_Loader::import(sprintf('%s/yaf/LocalAutoLoader.php', LIB_PATH));
        Yaf_Loader::import(sprintf('%s/yaf/YafController.php', LIB_PATH));
        Yaf_Loader::import(sprintf('%s/yaf/YafDebug.php', LIB_PATH));
        Yaf_Loader::import(sprintf('%s/yaf/YafView.php', LIB_PATH));
        Yaf_Loader::import(sprintf('%s/halo/HaloModel.php',LIB_PATH));
    }
}

SystemConfig::init();

