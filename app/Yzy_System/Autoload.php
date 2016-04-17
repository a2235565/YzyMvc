<?php
namespace Yzy_Ssytem;
class Autoload {
         static  function  autoload($class)
        {
                if($class==="Yzy_System\\C"){
                    require_once MYINDEX_DIR . "/app/Yzy_System/C.class.php";
                    return;
                }
                if($class==="Yzy_System\\Factory"){
                    require_once MYINDEX_DIR . "/app/Yzy_System/Factory.class.php";
                    return;
                }
                if($class==="Yzy_System\\Register"){
                    require_once MYINDEX_DIR . "/app/Yzy_System/Register.class.php";
                    return;
                }
                if($class==="Yzy_Ssytem\\conn\\Yzy_Conn"){
                    require_once  _MYINDEX_DIR . "/app/Yzy_System/conn/Yzy_Conn.php";
                    return;
                }
                if($class==="Yzy_Ssytem\\conn\\Yzy_Conn_Pdo"){
                    require_once  MYINDEX_DIR . "/app/Yzy_System/conn/Yzy_Conn_Pdo.php";
                    return;
                }
                $class=MYINDEX_DIR."/".$class.".php";
                $arr = explode('\\', $class);
                $class=implode("/",$arr);
                if(file_exists($class))
                require_once $class;
        }
}