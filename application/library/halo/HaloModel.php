<?php
/*
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-5-8
 * Time: 下午7:49
 */

class HaloModel{

    public  $error;
    public  $dbh;
    public  $dbname;

    public function __construct(){
        $config = Yaf_Registry::get('config');
        print_R($config);
        $port = isset($config['port']) ? $config['prot'] : 3306;
        $dsn = sprintf('mysql:host=%s;dbname=%s;port=%d', $config['host'], $config['dbname'], $port);
        $this->dbname = strtolower(trim($config['dbname']));
        try {
            $this->dbh = new PDO($dsn, $config['user'], $config['pass'],
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\'',
                    PDO::ATTR_PERSISTENT => false,
                    PDO::ATTR_EMULATE_PREPARES => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                ));
        } catch (Exception $e){
            if($this) $this->error = $e->getMessage();
        }

    }

}
?>