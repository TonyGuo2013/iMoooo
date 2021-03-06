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

    /*
     * 获取数据库一行
     */
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

    /*
     *  插入数据INSET INTO SET..
     */
    public function insertTable($table, $data)
    {
        if(!is_array($data))
            return false;

        list($fields, $values) = $this->getConditionArray($data);

        if (!count($values))
            return false;

        $sql = sprintf('INSERT INTO %s SET %s', $table, $fields);
//        echo $sql;
        $this->query($sql, $values);
        $insertId = $this->dbh->lastInsertId();
        if ($insertId === '0')
        {
            $desc = $this->get_results(sprintf('DESC %s', $table));
            $priField = '';
            foreach ($desc as $val)
            {
                if ($val['Key'] == 'PRI')
                {
                    $priField = $val['Field'];
                    break;
                }
            }
            if (!empty($priField))
            {
                $insertId = isset($data[$priField]) ? $data[$priField] : false;
            }
        }
        return ($insertId===false) ? false : intval($insertId);
    }

    /*
     * 转换条件数组
     */
    public function getConditionArray($data)
    {
        if(count($data) == 0)
            return array(null, null);

        $fields = array();
        $values = array();
        foreach($data as $k=>$v)
        {
            $fields[] = sprintf('%s='."'%s'", $k, $v);
            $values[] = $v;
        }

        return array(implode(',', $fields), $values);
    }

    /*
     * 获取全部结果集
     */
    public function get_results($sql, $values=null)
    {
        return $this->query($sql, $values)->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>