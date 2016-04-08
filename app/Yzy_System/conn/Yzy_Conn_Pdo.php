<?php
/**
 * Created by PhpStorm.
 * User: yzy
 * Date: 2016/2/20
 * Time: 21:03
 */
namespace Yzy_Ssytem\conn;
use PDO;
class Yzy_Conn_Pdo{
    protected  $conf;
    protected $db;
    function __construct($conf)
    {
        return $this->get($conf);
    }
      function get($conf)
    {
        $this->conf=$conf;
        if(! $this->db)
        {
            $dsn =  $this->conf['type'].":host=".$this->conf['host'].";dbname=".$this->conf['db_name'];
            try {
                $this->db = new PDO($dsn, $this->conf['username'], $this->conf['password'], array(PDO::ATTR_PERSISTENT => true));
            } catch (Exception $e) {
                die('连接数据库失败!');
            }
        }
        return  $this->db ;
    }

}