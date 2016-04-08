<?php
require_once "Error.php";

class Yzy_System
{
    public static function run(){
        // 设定错误和异常处理
        ini_set('display_errors', 1);
        register_shutdown_function('\Common_Error::fatalError');
        set_error_handler('\Common_Error::ErrorHandler');
        set_exception_handler('\Common_Error::appException');
        date_default_timezone_set('PRC');
        !file_exists(MYINDEX_DIR . "/Config/") && mkdir(MYINDEX_DIR . "/Config", 0777);
        if (!file_exists(MYINDEX_DIR . '/Config/Config.class.php')) {
            $counter_file = MYINDEX_DIR . '/Config/Config.class.php';
            $fopen = fopen($counter_file, 'wb ');//新建文件命令
            $dir = MYINDEX_DIR;
            !PATH_SEPARATOR==':' &&  $dir = str_replace("\\", "/", MYINDEX_DIR);

            fputs($fopen, '<?php
return array(
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
        }


        if (!file_exists(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/M/")) {
            mkdir(MYINDEX_DIR . "/Work", 0777);
            mkdir(MYINDEX_DIR . "/Work/".DEFAULT_DIR, 0777);
            mkdir(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/M/", 0777);
        }
        if (!file_exists(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/V/")) {
            mkdir(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/V/", 0777);
        }

        if (!file_exists(MYINDEX_DIR . '/Work/'.DEFAULT_DIR.'/M/TestM.class.php')) {
            $counter_file = MYINDEX_DIR . '/Work/'.DEFAULT_DIR.'/M/TestM.class.php';//文件名及路径,在当前目录下新建aa.txt文件
            $fopen = fopen($counter_file, 'wb ');//新建文件命令
            fputs($fopen, '<?php
namespace Work\\'.DEFAULT_DIR.'\M;
use M;
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
        if (!file_exists(MYINDEX_DIR . '/Work/Expansion/xx.class.php')) {
            $counter_file = MYINDEX_DIR . '/Work/Expansion/xx.class.php';//文件名及路径,在当前目录下新建aa.txt文件
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

        if (!file_exists(MYINDEX_DIR . '/Work/'.DEFAULT_DIR.'/C/IndexC.class.php')) {
            $counter_file = MYINDEX_DIR . '/Work/'.DEFAULT_DIR.'/C/IndexC.class.php';//文件名及路径,在当前目录下新建aa.txt文件
            $fopen = fopen($counter_file, 'wb ');//新建文件命令
            fputs($fopen, '<?php
namespace Work\\'.DEFAULT_DIR.'\C;
use C;
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
        if(!empty( $_GET['s'])) $action = $_GET['s'];
        if(empty($action)){
        $url = $_SERVER['PHP_SELF'];
        $action = explode('.php/', $url);
        }
        if(!empty($action[1]))
            $action = explode('/', $action[1]);
        else
            unset($action);

        require_once MYINDEX_DIR . "/app/Yzy_System/C.class.php";
        try {
            if (!empty($action[0])) {
                if (!empty($action[1]))
                    if (file_exists(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/C/" . $action[0] . "C.class.php")) {
                        require(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/C/" . $action[0] . "C.class.php");
                        $action1 = '\Work\\'.DEFAULT_DIR.'\\C\\' . $action[0];
                        $run = new $action1();
                        $fun=$action[1];
                        if(method_exists($run, $fun))
                        $run->$action[1]();
                        else
                             echo "<font color='red'>404 not font function</font>";
                    } else {
                        require(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/C/IndexC.class.php");
                        $class="\\Work\\".DEFAULT_DIR."\\C\\Index";
                        $run = new $class();
                        $run->Index();
                    }
                else {
                    echo "<font color='red'>404 not font page</font>";
                }

            } else {
                require_once(MYINDEX_DIR . "/Work/".DEFAULT_DIR."/C/IndexC.class.php");
                $class="\\Work\\".DEFAULT_DIR."\\C\\Index";
                $run = new $class();
                $run->Index();
            }
        } catch
        (Exception $e) {
            print $e->getMessage();
            exit();
        }
    }
    public function V($path = __CLASS__)
    {
        $smt = new Smarty();
        return $smt->display($path);
    }


}
