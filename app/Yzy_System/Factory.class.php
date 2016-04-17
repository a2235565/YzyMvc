<?php
namespace Yzy_System;
require_once "conn/Yzy_Conn.php";
class Factory {

  static function opendb($dbStyle)
  {
      $config = include(MYINDEX_DIR . "/Config/Config.class.php");
      if($config['pdostart']==0){

          $db=new \Yzy_Ssytem\conn\Yzy_Conn($config['db']['local'],$config['db']['user'],$config['db']['password'],$config['db']['char'],$config['db']['dbname']);
      }
      else{
          $db=new \Yzy_Ssytem\conn\Yzy_Conn_Pdo($config['pdo']);
          $db=$db->get($config['pdo']);
      }
      \Yzy_System\Register::set('db',$db);
      return $db;
  }

}