<?php

class M
{
    private $config;
    private $db;

     function  autoload($class)
    {
        $file = __DIR__."/".$class . '.php';
        if (is_file($file)) {
            require_once($file);
        }
    }

    public function  __construct()
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
            $this->db = Factory::opendb(1);
        return $this;
    }


    static function query($str,$htmlpower=true)
    {
        $str = preg_replace("/\s+/", " ", $str); //过滤多余回车
        $str = preg_replace("/<[ ]+/si", "<", $str); //过滤<__("<"号后面带空格)
        $str = preg_replace("/<\!–.*?–>/si", "", $str); //注释
        $str = preg_replace("/<(\!.*?)>/si", "", $str); //过滤DOCTYPE
        $str = preg_replace("/<(\/?html.*?)>/si", "", $str); //过滤html标签
        $str = preg_replace("/<(\/?head.*?)>/si", "", $str); //过滤head标签
        $str = preg_replace("/<(\/?meta.*?)>/si", "", $str); //过滤meta标签
        $str = preg_replace("/<(\/?body.*?)>/si", "", $str); //过滤body标签
        $str = preg_replace("/<(\/?link.*?)>/si", "", $str); //过滤link标签
        $str = preg_replace("/<(\/?form.*?)>/si", "", $str); //过滤form标签
        $str = preg_replace("/cookie/si", "COOKIE", $str); //过滤COOKIE标签
        $str = preg_replace("/<(applet.*?)>(.*?)<(\/applet.*?)>/si", "", $str); //过滤applet标签
        $str = preg_replace("/<(\/?applet.*?)>/si", "", $str); //过滤applet标签
        $str = preg_replace("/<(style.*?)>(.*?)<(\/style.*?)>/si", "", $str); //过滤style标签
        $str = preg_replace("/<(\/?style.*?)>/si", "", $str); //过滤style标签
        $str = preg_replace("/<(title.*?)>(.*?)<(\/title.*?)>/si", "", $str); //过滤title标签
        $str = preg_replace("/<(\/?title.*?)>/si", "", $str); //过滤title标签
        $str = preg_replace("/<(object.*?)>(.*?)<(\/object.*?)>/si", "", $str); //过滤object标签
        $str = preg_replace("/<(\/?objec.*?)>/si", "", $str); //过滤object标签
        $str = preg_replace("/<(noframes.*?)>(.*?)<(\/noframes.*?)>/si", "", $str); //过滤noframes标签
        $str = preg_replace("/<(\/?noframes.*?)>/si", "", $str); //过滤noframes标签
        $str = preg_replace("/<(i?frame.*?)>(.*?)<(\/i?frame.*?)>/si", "", $str); //过滤frame标签
        $str = preg_replace("/<(\/?i?frame.*?)>/si", "", $str); //过滤frame标签
        $str = preg_replace("/<(script.*?)>(.*?)<(\/script.*?)>/si", "", $str); //过滤script标签
        $str = preg_replace("/<(\/?script.*?)>/si", "", $str); //过滤script标签
        $str = preg_replace("/javascript/si", "Javascript", $str); //过滤script标签
        $str = preg_replace("/vbscript/si", "Vbscript", $str); //过滤script标签
        $str = preg_replace("/on([a-z]+)\s*=/si", "On\\1=", $str); //过滤script标签
        $htmlpower&&$str=htmlspecialchars($str);
        return mysql_query($str);
    }

}


