<?php
namespace Yzy_System;
class C
{
    private $smarty;
    protected $config,$_path;
    public function  __construct()
    {
        //设置报错日志
        $dir = MYINDEX_DIR;
        $this->config = include($dir . "/Config/Config.class.php");
        //开启报错日志
        $this->openlog();
//        $reflectionClass = new \ReflectionClass($this);
//        $dir = $reflectionClass->getFileName();
//        !(PATH_SEPARATOR==':')? $arr = explode('\\', $dir):$arr = explode('/', $dir);
//        array_pop($arr);
//        array_pop($arr);
//        $dir=implode("/",$arr);
        $dir=MYINDEX_DIR."/"."Work/".DEFAULT_DIR;
        if(file_exists($dir . "/Config/Config.class.php"))
        $temp=include_once($dir . "/Config/Config.class.php");
        if(!empty($temp))
        $this->config=array_merge($this->config,$temp);
        !PATH_SEPARATOR==':'? $dir .= "\\app\\":$dir .= "/app/";
        require_once MYINDEX_DIR . "/app/libs/Smarty.class.php";;
        $this->smarty = new \Smarty();
        return $this;
    }
    function openlog(){
        ini_set('display_errors',   $this->config['errodisplay']);
        if($this->config['errodisplay']){
        error_reporting(3);
        ini_set('los_errors', 1);
        ini_set('data.timezone', 'PRC');
        ini_set('error_log', MYINDEX_DIR . "Log/error-" . date("Y-m-d-H",time()) . ".log");
        ini_set('ignore_repeated_errors', 'on');
        ini_set('ignore_repeated_source', 'on');

        if (!file_exists(MYINDEX_DIR . "/Log/")) {
            mkdir(MYINDEX_DIR . "/Log/", 0777);
        }
        !file_exists(MYINDEX_DIR . "/Work/".DEFAULT_DIR . "/Config/") && mkdir(MYINDEX_DIR . "/Work/".DEFAULT_DIR . "/Config", 0777);
        if (!file_exists(MYINDEX_DIR . "/Work/".DEFAULT_DIR . '/Config/Config.class.php')) {
            $counter_file = MYINDEX_DIR . "/Work/".DEFAULT_DIR . '/Config/Config.class.php';
            $fopen = fopen($counter_file, 'wb ');//新建文件命令
            $dirs = MYINDEX_DIR;
            !PATH_SEPARATOR==':' &&  $dirs = str_replace("\\", "/", MYINDEX_DIR);
            fputs($fopen, '<?php
return array(
"smarty"=>array(
"template_dir"=>\'' . $dirs . "/Work/".DEFAULT_DIR."/V" . '\',
"compile_dir"=>\'' . $dirs . "/run/".DEFAULT_DIR."/V/" . DEFAULT_DIR.'\',
"config_dir"=>\'' . $dirs . "/Work/".DEFAULT_DIR."/V/" . 'config\',
"cache_dir"=>\'' . $dirs . "/run/".DEFAULT_DIR."/V/" .DEFAULT_DIR. 'cache\',
"left_delimiter"=>"{",
"right_delimiter"=>"}",
"caching"=>"true"
),
);
             ');//向文件中写入内容;
            fclose($fopen);
        }
        }
    }
    function index()
    {
        echo 'hello word';
    }

    function loadModel($class = '')
    {
        if (empty($class)) return null;
        if($this->config['pdostart'])
            require_once "MPDO.php";
        else
            require_once "M.class.php";
//        $reflectionClass = new \ReflectionClass($this);
//        $dir = $reflectionClass->getFileName();
//        !(PATH_SEPARATOR==':')? $arr = explode('\\', $dir):$arr = explode('/', $dir);
//        array_pop($arr);
//        array_pop($arr);
//        $dir=implode("/",$arr);
//        require_once $dir . "/M/". $class . "M.class.php";
        $action = "\\Work\\".DEFAULT_DIR."\\M\\" . $class;
        $action = new $action();
        return $action;
    }

    function loadExpansion($class = '')
    {
        if (empty($class)) return null;
        $action = "\\Work\\Expansion\\" . $class;
        $action = new $action();
        return $action;
    }

    function display($path = '')
    {
        if (!file_exists($this->config['smarty']['template_dir'])) {
            mkdir($this->config['smarty']['template_dir'], 0777,true);
        }
        if (!file_exists($this->config['smarty']['compile_dir'])) {
            mkdir($this->config['smarty']['compile_dir'], 0777,true);
        }
        if (!file_exists($this->config['smarty']['config_dir'])) {
            mkdir($this->config['smarty']['config_dir'], 0777,true);
        }
        if (!file_exists($this->config['smarty']['cache_dir'])) {
            mkdir($this->config['smarty']['cache_dir'], 0777,true);
        }
        $class = get_class($this);
        !PATH_SEPARATOR==':'? $arr = explode("\\", $class):$arr = explode("/", $class);
        $class = $arr[2];

        if (!file_exists($this->config['smarty']['template_dir'] . "/" . $class)) {
            mkdir($this->config['smarty']['template_dir'] . "/" . $class, 0777);
        }
        if (!file_exists($this->config['smarty']['template_dir'] . "/" . $class . "/" . $path)) {
            $counter_file = $this->config['smarty']['template_dir'] . "/" . $class . "/" . $path;//文件名及路径,在当前目录下新建aa.txt文件
            $fopen = fopen($counter_file, 'wb ');//新建文件命令
            fputs($fopen, '<!DOCTYPE html>
            <html>
            <head lang="en">
                <meta charset="UTF-8">
                <title></title>
            </head>
            <body>
{$data}
            </body>
            </html>');//向文件中写入内容;
            fclose($fopen);
        }
        $this->smarty->template_dir = $this->config['smarty']['template_dir'] . "/" . $class;    //指定模版存放目录
        $this->smarty->compile_dir = $this->config['smarty']['compile_dir'];    //指定编译文件存放目录
        $this->smarty->config_dir = $this->config['smarty']['config_dir'];    //指定配置文件存放目录
        $this->smarty->cache_dir = $this->config['smarty']['cache_dir'];    //指定缓存存放目录
        $this->smarty->caching = $this->config['smarty']['caching'];    //关闭缓存（设置为true表示启用缓存）
        $this->smarty->left_delimiter = $this->config['smarty']['left_delimiter'];    //指定左标签
        $this->smarty->right_delimiter = $this->config['smarty']['right_delimiter'];    //指定右标签

        $dir = $_SERVER['HTTP_HOST'];
        $dir .= $_SERVER['PHP_SELF'];

        $arr = explode('.php', $dir);
        if (count($arr) > 1) {
            array_pop($arr);
            $arr = explode('/', $arr[0]);
            array_pop($arr);
            $dir=implode("/",$arr);

        }
        else
        {
            $dir=   $arr[0];
        }

        $this->smarty->assign('__PUBLIC__', '/Work/Public/');
        $this->smarty->display($path);
    }

    function assgin($name, $data)
    {
        $this->smarty->assign($name, $data);
    }

}