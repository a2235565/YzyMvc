<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/30
 * Time: 1:29
 */
require_once "conn/Yzy_Conn.php";
class Factory {

  static function opendb($dbStyle)
  {
      header("Content-type:text/html;charset=UTF-8");
      $dir = __DIR__;
      !PATH_SEPARATOR==':'?$arr = explode('\\', $dir):$arr = explode('/', $dir);
      array_pop($arr);
      array_pop($arr);

      $dir = '';
      foreach ($arr as $v) {
          $dir .= $v . "/";
      }
        $config = include($dir . "Config/Config.class.php");

      if($config['pdostart']==0){
          require_once  __DIR__."/conn/Yzy_Conn.php";
          $db=new \Yzy_Ssytem\conn\Yzy_Conn($config['db']['local'],$config['db']['user'],$config['db']['password'],$config['db']['char'],$config['db']['dbname']);
      }
      else{
          require_once  __DIR__."/conn/Yzy_Conn_Pdo.php";
          $db=new \Yzy_Ssytem\conn\Yzy_Conn_Pdo($config['pdo']);
          $db=$db->get($config['pdo']);
      }
      Register::set('db',$db);
      return $db;
  }

}