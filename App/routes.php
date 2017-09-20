<?php
/*
 * 中间件
 */
//处理带有斜线结尾的URL和不带斜线的URL的方式不同
$app -> add('\App\Middlewares\TrailingSlashMiddleware');

/*
 * 登录
 */
$app->get('/','App\Controllers\UserController:login');	
$app->get('/login','App\Controllers\UserController:login') -> setname('Login');	
$app->post('/login','App\Controllers\UserController:postLogin');	
$app->get('/loginout','App\Controllers\UserController:logout') -> setname('Logout');	
$app -> get('/404', 'App\Controllers\BaseController:Error') -> setname('Error');


/*
 * 普通用户用户登录
 */
$app -> get('/normal/index', 'App\Controllers\NormalController:PersonIndex');

/*
 * 管理员用户用户登录
 */
$app -> get('/user/list', 'App\Controllers\UserController:UserList');
$app -> get('/user/info', 'App\Controllers\UserController:UserInfo');
$app -> get('/user/index', 'App\Controllers\UserController:UserIndex') ;
$app -> get('/user/item', 'App\Controllers\UserController:UserItem');
$app -> get('/user/select', 'App\Controllers\UserController:UserSelect');
$app -> post('/user/add', 'App\Controllers\UserController:UserAdd');
$app -> post('/user/delete', 'App\Controllers\UserController:UserDelete');
$app -> post('/user/update', 'App\Controllers\UserController:UserUpdate');


/*
 * 超级管理员用户用户登录
 */

$app -> get('/role/index','App\Controllers\RoleController:RoleIndex');
$app -> get('/role/user/list','App\Controllers\RoleController:RoleList');
$app -> get('/role/user/info','App\Controllers\RoleController:UserInfo');

$app->group('',function(){
//	$this -> post('/user/add', 'App\Controllers\UserController:UserAdd');
//	$this -> post('/user/update', 'App\Controllers\UserController:UserUpdate');
//	$this -> post('/user/delete', 'App\Controllers\UserController:UserDelete');
//	$this -> get('/user/select', 'App\Controllers\UserController:UserSelect');
//	$this -> get('/user/info', 'App\Controllers\UserController:UserInfo');
//	$this -> get('/user/item', 'App\Controllers\UserController:UserItem');
//	$this -> get('/user/list', 'App\Controllers\UserController:UserList');
	
	$this -> post('/role/add', 'App\Controllers\RoleController:RoleAdd');
	$this -> post('/role/delete', 'App\Controllers\RoleController:RoleDelete');
	$this -> post('/role/update', 'App\Controllers\RoleController:RoleUpdate');
//	$this -> get('/role/list', 'App\Controllers\RoleController:RoleList');
})-> add(new App\Middlewares\RoleMiddleware($container)) -> add(new App\Middlewares\AuthMiddleware($container));
?>