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
    public  $last_query;

    public function __construct(){
        $config = Yaf_Registry::get('dbconfig');
        $port = isset($config->db->imoooo->port) ? $config->db->imoooo->port : 3306;
        $dsn = sprintf('mysql:host=%s;dbname=%s;port=%d', $config->db->imoooo->host, $config->db->imoooo->name, $port);
        $this->dbname = strtolower(trim($config->db->imoooo->name));
//        echo $dsn;
        try {
            $this->dbh = new PDO($dsn, $config->db->imoooo->user, $config->db->imoooo->pass,
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

    public function query($sql, $values=null)
    {
//        echo $sql;
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($values);
        $this->last_query = $stmt->queryString;
        return $stmt;
    }

    public function getRowByCondition($table, $condition, $fields='')
    {
        list($condition, $values) = $this->getConditionPair($condition);
        if(empty($fields))
            $sql = sprintf('SELECT * FROM %s WHERE %s LIMIT 1',$table, $condition);
        else
            $sql = sprintf('SELECT %s FROM %s WHERE %s LIMIT 1',$fields,$table,$condition);
        return $this->get_row($sql, $values);
    }

    public function get_row($sql,  $values=null)
    {
        return $this->query($sql, $values)->fetch(PDO::FETCH_ASSOC);
    }

    private  function getConditionPair($condition)
    {
        if (is_array($condition))
        {
            return $condition;
        }

        if (empty($condition) || is_string($condition))
        {
            return array($condition, null);
        }
    }
}
?>