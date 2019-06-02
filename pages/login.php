<?php
/**
 * Created by PhpStorm.
 * User: LunZi
 * Date: 2019/4/24
 * Time: 21:04
 */

    include_once("connect/database.php");
    $userName = addslashes($_POST['userName']);
    $password = addslashes($_POST['password']);
    $mysqli_result = mysqli_query($conn,"SELECT `Id`, `Password`, `Power` FROM `user` WHERE Id='$userName' and Password='$password'");
    $my=mysqli_fetch_array($mysqli_result);
    $Power=$my['Power'];
    if ($my['Id'] ==$userName) {
        setcookie ( 'user_power', $Power, 0, '/' );
        setcookie ( 'user', $userName, 0, '/' );
        switch ($my['Power']){
            case 1:
                header("Location: ?r=superadmin");
                break;

            case 2:
                header("Location: ?r=normaladmin");
                break;

            case 3:
                header("Location: ?r=student");
                break;
        }
    }
    else {
        echo '<script>alert("账号或密码错误");history.go(-1);</script>';
    }
    mysqli_close();

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>登录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
    <style>
        .header {
            text-align: center;
        }
        .header h1 {
            font-size: 200%;
            color: #333;
            margin-top: 30px;
        }
        .header p {
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="am-g">
        <h1>学生宿舍管理系统</h1>
        <!--<p>Integrated Development Environment<br/>代码编辑，代码生成，界面设计，调试，编译</p>-->
    </div>
    <hr />
</div>
<div class="am-g">
    <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
        <h3>登录</h3>
        <hr>
        <div class="am-btn-group">
        </div>
        <br>
        <br>

        <form action="?r=login" method="POST" class="am-form">
            <label >账号or学号:</label>
            <input type="text" name="userName"  value="">
            <br>
            <label for="password">密码:</label>
            <input type="password" name="password" id="password" value="">
            <br>
            <label for="remember-me">
                <input id="remember-me" type="checkbox">
                记住密码
            </label>
            <br />
            <div class="am-cf">
                <input type="submit" name="" value="登 录" class="am-btn am-btn-primary am-btn-sm am-fl">
                <input type="reset" name="cancel" value="重填" class="am-btn am-btn-default am-btn-sm am-fr">
            </div>
        </form>
        <hr>

    </div>
</div>
</body>
</html>

