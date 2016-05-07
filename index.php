<?php
define('DS',        DIRECTORY_SEPARATOR );    //斜杠
define('WEB_DIR',   ( __DIR__ ));       //根目录
define('PZ_DIR',    ( __DIR__ ).DS."pzphp");     //核心文件目录



define('APP_DIR',   ( __DIR__ ).DS."app");  //业务代码目录

require PZ_DIR.DS.'Pz.php';
//判断是否是部署在linux服务器
//FreeBSD CYGWIN_NT-5.1  Darwin IRIX64 OpenBSD SunOS NetBSD WINNT WIN32 Windows Unix HP-UX
if(PHP_OS != 'Linux') 
{
    die('本程序仅部署在linux服务器下');
}
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
	die('本程序不支持php5.4以下');
}

//启动应用
Pz::start();
 