<?php

require 'connect/database.php';//链接数据库
require 'include/checklogin.php';

// 查询最新 15 条学生记录
$query = mysqli_query($conn,"SELECT student.*,user.UserName FROM student,`user` WHERE Stu_No=Id AND Power=3 ORDER BY Stu_No DESC LIMIT 15");

////查询超级管理员记录
$super_admins_query=mysqli_query($conn,"SELECT * FROM `user` WHERE Power=1 ORDER BY user_Num DESC");
$super_admins_count=mysqli_num_rows($super_admins_query);

////查询普通管理员记录
$normal_admin_query=mysqli_query($conn,"SELECT * FROM `user` WHERE Power=2 ORDER BY user_Num DESC");
$normal_admins_count=mysqli_num_rows($normal_admin_query);

//// 查询所有学生记录
$student_query=mysqli_query($conn,"SELECT * FROM `user` WHERE Power=3 ORDER BY user_Num DESC");
$students_count=mysqli_num_rows($student_query);

////查询所有宿舍楼记录
$dormitory_builds_query=mysqli_query($conn,"SELECT * FROM build ORDER BY Build_Id ");
$dormitory_builds_count=mysqli_num_rows($dormitory_builds_query);

////查询所有宿舍记录
$dormitories_query = "SELECT * FROM dormitory ORDER BY Dor_Id ";
$dormitories_result = mysqli_query($conn,$dormitories_query);

?>

<!doctype html>
<html class="no-js fixed-layout">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Amaze UI Admin index Examples</title>
    <meta name="description" content="这是一个 index 页面">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
    以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar am-topbar-inverse admin-header">
    <?php require 'tools/header.php'; ?>
</header>

<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php require 'tools/siderbar.php'; ?>

    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">首页</strong> / <small>所有用户信息</small></div>
            </div>

            <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list ">
                <li><a href="?r=show-admin-normal" class="am-text-warning"><span class="am-icon-btn am-icon-user-md"></span><br/>普通管理员<br/><?php echo $normal_admins_count?></a></li>
                <li><a href="#" class="am-text-danger"><span class="am-icon-btn am-icon-recycle"></span><br/>宿舍楼<br/><?php echo $dormitory_builds_count?></a></li>
                <li <?php if ($user_power == 3) echo 'readonly="true"' ?> ><a href="?r=show-stu" class="am-text-secondary"><span class="am-icon-btn am-icon-users"></span><br/>学生<br/><?php echo $students_count?></a></li>
            </ul>

            <div class="am-g">
                <div class="am-u-sm-12 table-container">
                    <table class="am-table am-table-bd am-table-striped admin-content-table">
                        <thead>
                        <tr>
                            <th>学号</th>
                            <th>姓名</th>
                            <th>性别</th>
                            <th>年龄</th>
                            <th>所在院系</th>
                            <th>年级</th>
                            <th>电话</th>
                            <th>宿舍楼</th>
                            <th>宿舍号</th>
                            <th>床号</th>
                            <th>管理</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        // 结果集遍历到数组
                        while ( $student = mysqli_fetch_array ( $query ) ) {
                            ?>
                            <tr>
                                <td><?php echo $student['Stu_No']?></td>
                                <td><?php echo $student['UserName']?></td>
                                <td><?php echo $student['Stu_Sex']?></td>
                                <td><?php echo $student['Stu_Age']?></td>
                                <td><?php echo $student['Stu_Department']?></td>
                                <td><?php echo $student['Stu_Grade']?></td>
                                <td><?php echo $student['Stu_Phone']?></td>
                                <?php
                                // 查询 当前学生所在的宿舍楼名
                                $user_stu_current_dor_build_query=mysqli_query($conn,"SELECT build.Build_Name, build.Build_Id FROM dormitory,Build WHERE dormitory.Dor_Id='{$student['Dor_Id']}' AND dormitory.Build_Id=Build.Build_Id");
                                $user_stu_current_dor_build = mysqli_fetch_array($user_stu_current_dor_build_query);
                                // 查询 当前学生所在的宿舍号
                                $user_stu_current_dor_query=mysqli_query($conn,"SELECT * FROM dormitory,build WHERE dormitory.Dor_Id='{$student['Dor_Id']}' AND dormitory.Build_Id=Build.Build_Id");
                                $users_stu_current_dor=mysqli_fetch_array($user_stu_current_dor_query);
                                ?>
                                <td><span class="am-badge am-badge-secondary"><?php echo $user_stu_current_dor_build['Build_Name']?></span></td>
                                <td><?php echo $users_stu_current_dor['Dor_No']?></td>
                                <td><?php echo $student['Dor_DedNum']?></td>
                                <td>
                                    <div class="am-dropdown" data-am-dropdown>
                                        <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>
                                        <ul class="am-dropdown-content">
                                            <li><a href="?r=user-stu&sno=<?php echo $student['Stu_No'] ?>&edit_target=<?php if ($student['Stu_No'] == $user_no) echo "self"; else echo "others"; ?>">1. 编辑</a></li>
                                            <li><a href="?r=user-delete&delete_no=<?php echo $student['Stu_No'] ?>&isdelete=true&from=index" onclick="return confirm('删除后无法恢复数据，是否继续？');">2. 删除</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php }?>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>