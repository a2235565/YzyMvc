<?php
/**
 * Created by PhpStorm.
 * User: yzy
 * Date: 2016/2/20
 * Time: 21:33
 */

/*
 * code by yzy
 * test
define("__BASEDIRSYZY__",__DIR__);
include __BASEDIRSYZY__."/Tool/Loader.php";
spl_autoload_register("\\Tool\\Loader::autoload");
include "/Tool/function.php";
$f=new \Tool\ModelTool("db1");
//$data=$f->query("select * from test ");
$stmt=$f->stmt("select d from test where `d`=?");
//$f->bd($stmt,1,"2","int");
$f->exec($stmt,array("2"));
$temp=$f->rsArray($stmt);
var_dump($temp);
$temp=I("get.");
dump($temp);
 */
class M{
    protected static $db;
    //构造数据库连接

    function  autoload($class)
    {
        $file = __DIR__."/".$class . '.php';
        if (is_file($file)) {
            require_once($file);
        }
    }

    function __construct()
    {
        spl_autoload_register(array('M', 'autoload'));
        $dir = __DIR__;
        !PATH_SEPARATOR==':'?$arr = explode('\\', $dir):$arr =explode('/', $dir);
        array_pop($arr);
        array_pop($arr);
        $dir = '';
        foreach ($arr as $v) {
            $dir .= $v . "/";
        }
        $this->config = include($dir . "Config/Config.class.php");
        $db = Register::get('db');
        if (!isset($db))
            self::$db = Factory::opendb(1);
        return $this;

    }
    //启动事物
    function startTransaction()
    {
        self::$db->beginTransaction();
    }
    //发送事物
    function Commit()
    {
        self::$db->commit();
    }
    //直接执行sql语句
    function query($sql)
    {
        if(substr(trim($sql),0,6)==="select")
        {
            $rs=self::$db->query($sql);
            return $rs->fetchAll();
        }
        else
        return self::$db->exec($sql);
    }
    //开启参数绑定
    function stmt($sqls)
    {
       return self::$db->prepare($sqls);
    }
    //绑定参数
    function exec($stmt,$val)
    {
        return $stmt->execute($val);
    }
    //返回结果集
    function rsArray($stmt)
    {
        return $stmt->fetchAll();
    }



}