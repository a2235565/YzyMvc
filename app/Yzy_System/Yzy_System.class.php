<?php
namespace Yzy_System;
require_once "Error.php";
require_once "Autoload.php";

class Yzy_System
{
    public static function run(){
        spl_autoload_register(array("Yzy_Ssytem\\Autoload", 'autoload'));
        $me=new Yzy_System();
        $me->erro();
        session_start();
        $me->isFirst();
        include "function/function.php";
        $me->route();
    }
    function erro(){
        // 设定错误和异常处理
        register_shutdown_function('Yzy_System\Common_Error::fatalError');
        set_error_handler('Yzy_System\Common_Error::ErrorHandler');
        set_exception_handler('Yzy_System\Common_Error::appException');
        date_default_timezone_set('PRC');
        if(!file_exists(MYINDEX_DIR."/Config/Config.class.php")){
            ini_set('display_errors', 1);
            header("Content-type:text/html;charset=UTF-8");
        }
        else
        {
            $conf=include(MYINDEX_DIR."/Config/Config.class.php");
            ini_set('display_errors', $conf['errodisplay']);
            header("Content-type:text/html;charset=".$conf['charType']);
        }
        header("X-Powered-By:YzySystem");
    }
    function route(){
        if(!empty( $_GET['s'])) $action = $_GET['s'];
        if(empty($action)){
            $url = $_SERVER['PHP_SELF'];
            $action = explode('.php/', $url);
            if(!empty($action[1]))
                $action = explode('/', $action[1]);
            else
                unset($action);
        }else {
            $action = explode('/', $action);
        }
        if (!empty($action[0]))
        {
            if (!empty($action[1]))
            {
                if (file_exists(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/C/" . $action[0] . ".php"))
                {
                    $action1 = '\\Work\\'.DEFAULT_DIR.'\\C\\' . $action[0];
                    $run = new $action1();
                    $fun=$action[1];
                    if(method_exists($run, $fun)){
                        $run->$action[1]();
                    }
                    else{
                        trigger_error("未找到您的function方法",256);
                    }
                }
                else
                {
                    $class="\\Work\\".DEFAULT_DIR."\\C\\Index";
                    $run = new $class();
                    $run->Index();
                }
            }
            else
            {
                echo "<font color='red'>404 not font page</font>";
                die();
            }
        }
        else
        {
            $class="\\Work\\".DEFAULT_DIR."\\C\\Index";
            $run = new $class();
            $run->index();
        }
    }
    function  isFirst()
    {
        !file_exists(MYINDEX_DIR . "/Config/") && mkdir(MYINDEX_DIR . "/Config", 0777);
        if (!file_exists(MYINDEX_DIR . '/Config/Config.class.php')) {
            $counter_file = MYINDEX_DIR . '/Config/Config.class.php';
            $fopen = fopen($counter_file, 'wb ');//新建文件命令
            $dir = MYINDEX_DIR;
            !PATH_SEPARATOR==':' &&  $dir = str_replace("\\", "/", MYINDEX_DIR);
            fputs($fopen, '<?php
return array(
"charType"=>"UTF-8",
"errodisplay"=>1,
"db"=>array(
"user"=>"root",
"password"=>"",
"local"=>"127.0.0.1",
"dbname"=>"test",
"dbtype"=>"mysql",
"char"=>"utf8",
),
"pdostart"=>0,//未开启
"pdo"=>array(
    "type" => "mysql",
    "db_name" => "test",
    "host" => "127.0.0.1",
    "username" => "root",
    "password" => "root"
),
);
             ');//向文件中写入内容;
            fclose($fopen);

        if (!file_exists(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/M/")) {
            mkdir(MYINDEX_DIR . "/Work", 0777);
            mkdir(MYINDEX_DIR . "/Work/".DEFAULT_DIR, 0777);
            mkdir(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/M/", 0777);
        }
        if (!file_exists(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/V/")) {
            mkdir(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/V/", 0777);
        }

        if (!file_exists(MYINDEX_DIR . '/Work/'.DEFAULT_DIR.'/M/Test.php')) {
            $counter_file = MYINDEX_DIR . '/Work/'.DEFAULT_DIR.'/M/Test.php';//文件名及路径,在当前目录下新建aa.txt文件
            $fopen = fopen($counter_file, 'wb ');//新建文件命令
            fputs($fopen, '<?php
namespace Work\\'.DEFAULT_DIR.'\M;
use Yzy_System\M;
class Test extends M{
      public  function test()
        {
            $res=$this->query("show databases");
            return   $res;
//            $stmt=$this->stmt("select d from test where `d`=?");
//            $this->exec($stmt,array("2"));
//            $temp=$this->rsArray($stmt);
//            var_dump($temp);
        }
}');
            fclose($fopen);
        }

        if (!file_exists(MYINDEX_DIR . "/Work/Public/")) {
            mkdir(MYINDEX_DIR . "/Work/Public/", 0777);
        }
        if (!file_exists(MYINDEX_DIR . "/Work/Expansion/")) {
            mkdir(MYINDEX_DIR . "/Work/Expansion/", 0777);
        }
        if (!file_exists(MYINDEX_DIR . '/Work/Expansion/xx.php')) {
            $counter_file = MYINDEX_DIR . '/Work/Expansion/xx.php';//文件名及路径,在当前目录下新建aa.txt文件
            $fopen = fopen($counter_file, 'wb ');//新建文件命令
            fputs($fopen, '<?php
namespace Work\Expansion;
class xx
{
    public function  __construct()
    {
        return $this;
    }

    public function test()
    {
        echo \'Expansion is  run\';
    }
}');//向文件中写入内容;
            fclose($fopen);
        }
        if (!file_exists(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/C/")) {
            mkdir(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/C/", 0777);
        }

        if (!file_exists(MYINDEX_DIR . '/Work/'.DEFAULT_DIR.'/C/Index.php')) {
            $counter_file = MYINDEX_DIR . '/Work/'.DEFAULT_DIR.'/C/Index.php';//文件名及路径,在当前目录下新建aa.txt文件
            $fopen = fopen($counter_file, 'wb ');//新建文件命令
            fputs($fopen, '<?php
namespace Work\\'.DEFAULT_DIR.'\C;
use Yzy_System\C;
class Index extends C
{
    function index()
    {
        $model = $this->loadModel(\'Test\');
        $dome=$model->test();
        while($res=mysql_fetch_array($dome))
        var_dump($res);


        $ep=$this->loadExpansion(\'xx\');
        $ep->test();
        $this->assgin(\'data\',\'hello world\');
        $this->display(\'hellow.tpl\');
    }
}');//向文件中写入内容;
            fclose($fopen);
        }
        }
    }

}
