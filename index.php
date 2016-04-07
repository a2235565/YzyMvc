<?php
/****/
ini_set('display_errors','on');

define("MYINDEX_DIR",__dir__);

define("DEFAULT_DIR",'Home');

require(MYINDEX_DIR.'/app/Yzy_System/Yzy_System.class.php');
Yzy_System::run();
