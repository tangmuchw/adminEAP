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
$app->get('/loginout','App\Controllers\UserController:logout');	
$app -> get('/404', 'App\Controllers\BaseController:Error') -> setname('Error');




$app->group('',function(){
	$this-> get('/base/getMyselfInfo', 'App\Controllers\BaseController:getMyselfInfo');
	$this-> post('/base/setMyselfInfo', 'App\Controllers\BaseController:setMyselfInfo');
 	$this-> get('/base/selfSearch', 'App\Controllers\BaseController:selfSearch');
/*
 * 普通用户用户登录
 */
 	$this-> get('/normal/index', 'App\Controllers\NormalController:NormalIndex');
 	$this-> get('/normal/self', 'App\Controllers\NormalController:NormalSelf');
 
 /*
  * 管理员用户用户登录
  */
 	$this-> get('/user/list', 'App\Controllers\UserController:UserList');
 	$this-> get('/user/info', 'App\Controllers\UserController:UserInfo');
 	$this-> get('/user/index', 'App\Controllers\UserController:UserIndex') ;
 	$this-> get('/user/select', 'App\Controllers\UserController:UserSelect');

 	$this-> get('/user/self', 'App\Controllers\UserController:UserSelf');
 	$this-> post('/user/add', 'App\Controllers\UserController:UserAdd');
 	$this-> post('/user/delete', 'App\Controllers\UserController:UserDelete');
 	$this-> post('/user/update', 'App\Controllers\UserController:UserUpdate');

 
 
 /*
  * 超级管理员用户用户登录
  */
 
 	$this-> get('/role/index','App\Controllers\RoleController:RoleIndex');
 	$this-> get('/role/user/userList','App\Controllers\RoleController:RoleUserList');
 	$this-> get('/role/user/info','App\Controllers\RoleController:UserInfo');
 	$this-> get('/role/list','App\Controllers\RoleController:RoleList');
 	$this-> get('/role/info','App\Controllers\RoleController:RoleInfo');
 	$this-> get('/role/select','App\Controllers\RoleController:RoleSelect');
 	$this-> get('/role/fullInfo','App\Controllers\RoleController:RoleFullInfo');
 	$this-> get('/role/usertorole','App\Controllers\RoleController:RoleSelectUserToRole');
	 $this-> get('/role/usertorole/search','App\Controllers\RoleController:RoleSelectRoleOfUser');
 	$this-> get('/role/self','App\Controllers\RoleController:RoleSelf');
 
 	$this-> post('/role/add','App\Controllers\RoleController:RoleAdd');
 	$this-> post('/role/delete','App\Controllers\RoleController:RoleDelete');
 	$this-> post('/role/update','App\Controllers\RoleController:RoleUpdate');
 	$this-> post('/role/usertorole/delete','App\Controllers\RoleController:RoleRoleOfUserDelete');
    $this-> post('/role/usertorole/add','App\Controllers\RoleController:RoleRoleOfUserAdd');
 
 
})-> add(new App\Middlewares\RoleMiddleware($container)) -> add(new App\Middlewares\AuthMiddleware($container));
?>