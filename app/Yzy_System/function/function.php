<?php
//显示ajax
function msgJson($msg){
    echo json_encode($msg);
    die();
}
//加密
function enYzyCodes($data, $key)
{
    $x  = 0;
    $len = strlen($data);
    $l  = strlen($key);
    $char="";
    for ($i = 0; $i < $len; $i++)
    {
        if ($x == $l)
        {
            $x = 0;
        }
        $char .= $key{$x};
        $x++;
    }
    $str="";
    for ($i = 0; $i < $len; $i++)
    {
        $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
    }
    return base64_encode($str);
}
//解密
function deYzyCodes($data, $key)
{
    $x = 0;
    $data = base64_decode($data);
    $len = strlen($data);
    $l = strlen($key);
    $char="";
    for ($i = 0; $i < $len; $i++)
    {
        if ($x == $l)
        {
            $x = 0;
        }
        $char .= substr($key, $x, 1);
        $x++;
    }
    $str="";
    for ($i = 0; $i < $len; $i++)
    {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
        {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }
        else
        {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return $str;
}
function session($name,$value=null){
    if(!empty($value)||$value===0)
        $_SESSION[$name]=$value;
    else
        return  $_SESSION[$name];
}
function cookie($name,$value,$time=null){
    $value=enYzyCodes($name,$value);
    $name=substr(md5($name."yzy"),0,10);
    if($time!=-1)
    empty($time) && ($time=time()+3600 )||$time=$time+time();

    if(!empty($value)||$value===0)
        setcookie($name,$value,$time,"/");
    else
        return  deYzyCodes($_COOKIE[$name],$name);
}
function isPost(){
  return  $_SERVER['REQUEST_METHOD']==="POST";
}
function isAjax(){
  return   isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest');
}