<?php
 //数据库配置
    $config['db']['host'] = "127.0.0.1";
    $config['db']['username'] = "root";
    $config['db']['password'] = "123456";
    $config['db']['dbname'] = "roledb";

    //默认控制器和操作名
    $config['defaultController'] = 'User';
    $config['defaultAction'] = 'index';

    return $config;
?>