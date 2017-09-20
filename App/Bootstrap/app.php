<?php
//防止无权访问时，自动下载错误提示文本
header("Content-type:text/html"); 

//开启session	
session_start();

//定义路径常量
define('ROOT_PATH',__DIR__.'/../../');
define('VENDOR_PATH',__DIR__.'/../../vendor/');
define('APP_PATH',__DIR__.'/../../App/');
define('PUBLIC_PATH',__DIR__.'/../../Public');

require VENDOR_PATH.'autoload.php';

//加载App配置
require APP_PATH.'Config/config.php';

//初始化应用程序对象
$app =new \Slim\App($config);

//获取容器对象
$container = $app->getContainer();

//加载数据库配置
$GLOBALS['config'] = require_once APP_PATH.'Config/database.php';
//		var_dump($GLOBAL['config']);
//加载路由配置
require APP_PATH.'routes.php';

//返回应用程序对象
return $app;

?>