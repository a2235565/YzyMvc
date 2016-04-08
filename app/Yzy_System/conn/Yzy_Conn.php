<?php
namespace Yzy_Ssytem\conn;
class Yzy_Conn
{

function __construct($local='127.0.0.1',$user="root",$pass='',$char="utf8",$dbname="test")
{
    $this->startConn($local,$user,$pass,$char,$dbname);
}

    function startConn($local='127.0.0.1',$user="root",$pass='',$char="utf8",$dbname="test")
    {
        @$con = mysql_connect($local, $user, $pass);//
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db($dbname, $con);
        mysql_query("set names ".$char);
        return $con;
    }

    function offConn($con = null)
    {
        mysql_close($con);
    }
}