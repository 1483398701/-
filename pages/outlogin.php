<?php
/**
 * Created by PhpStorm.
 * User: LUNZI
 * Date: 2019/5/5
 * Time: 10:01
 */
// 清除 cookie 值，退出登录
setcookie ( 'user', '', 0, '/' );
// 重定向页面到 登录页面
header("Location:?r=login");