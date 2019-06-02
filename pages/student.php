<?php
/**
 * Created by PhpStorm.
 * User: LunZi
 * Date: 2019/5/5
 * Time: 9:51
 */

require 'connect/database.php';//链接数据库
//require 'inc/checklogin.php';

$user = $_COOKIE ['user'];
$Power = $_COOKIE ['Power'];
//echo $user;

// 查询最新 15 条学生记录
$query = mysqli_query($conn,"SELECT * FROM student,user WHERE Stu_No='$user' AND Stu_No=Id");
//var_dump($query);


//
//// 查询所有学生记录
$student_query=mysqli_query($conn,"SELECT * FROM `user` WHERE Power=3 ORDER BY user_Num DESC");
$students_count=mysqli_num_rows($student_query);
//$student_query = "SELECT * FROM `user` WHERE Power=3 ORDER BY user_Num DESC";
//$student_result = mysqli_query($conn,$student_query) or die ('SQL语句有误：' . mysqli_error($conn));
//$students_count = mysqli_num_rows($student_result);
//
////查询所有宿舍楼记录
$dormitory_builds_query=mysqli_query($conn,"SELECT * FROM build ORDER BY Build_Id ");
$dormitory_builds_count=mysqli_num_rows($dormitory_builds_query);
//$dormitory_builds_query = "SELECT * FROM build ORDER BY Build_Id ";
//$dormitory_builds_result = mysqli_query($conn,$dormitory_builds_query) or die ('SQL语句有误：' . mysqli_error($conn));
//$dormitory_builds_count = mysqli_num_rows($dormitory_builds_result);
//
////查询所有宿舍记录
//$dormitories_query = "SELECT * FROM dormitory ORDER BY Dor_Id ";
//$dormitories_result = mysqli_query($conn,$dormitories_query) or die ('SQL语句有误：' . mysqli_error($conn));
//$dormitories_count = mysqli_num_rows($dormitories_result);

$data_href = "?r=user-stu&sno={$user}&edit_target=self";
?>

<!doctype html>
<html class="no-js fixed-layout">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>学生</title>
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
    <div class="am-topbar-brand">
        <strong>学生宿舍</strong> <small>管理系统</small>
    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
<!--            <li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">5</span></a></li>-->
            <li class="am-dropdown" data-am-dropdown>
                <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                    <span class="am-icon-users"></span> 学生 <span class="am-icon-caret-down"></span>
                </a>
                <ul class="am-dropdown-content">
                    <li><a href="#"><span class="am-icon-user"></span> 资料</a></li>
                    <li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>
                    <li><a href="#"><span class="am-icon-power-off"></span> 退出</a></li>
                </ul>
            </li>
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>

<div class="am-cf admin-main">
    <!-- sidebar start -->
<!--    --><?php //require '../tools/sidebar.php'; ?>
    <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
        <div class="am-offcanvas-bar admin-offcanvas-bar">
            <ul class="am-list admin-sidebar-list">
                <li><a href="<?php echo $data_href?>"><span class="am-icon-home"></span> 个人信息</a></li>
                <li><a href="?r=show-visit"><span class="am-icon-table"></span> 来访记录</a></li>
                <li><a href="?r=outlogin"><span class="am-icon-sign-out"></span> 注销</a></li>
            </ul>
        </div>
    </div>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">首页</strong> / <small>所有用户信息</small></div>
            </div>

            <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list ">
                <li <?php if ($user_power == 3) echo 'readonly="true"' ?>><a href=# class="am-text-secondary"><span
                                class="am-icon-btn am-icon-users"></span><br/>学生<br/><?php echo $user?></a></li>
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
                                /*$user_stu_current_dor_build_query = "SELECT dormitory_builds.db_name, dormitory_builds.db_id FROM dormitories,dormitory_builds WHERE dormitories.d_id='{$students['d_id']}' AND dormitories.db_id=dormitory_builds.db_id";
                                $user_stu_current_dor_build_result = mysqli_query($conn,$user_stu_current_dor_build_query) or die ('SQL语句有误：' . mysqli_error($conn));
                                $user_stu_current_dor_build = mysqli_fetch_array($user_stu_current_dor_build_result);*/
                                $user_stu_current_dor_build = mysqli_fetch_array($user_stu_current_dor_build_query);
                                // 查询 当前学生所在的宿舍号
/*                                $users_stu_current_dor_query = "SELECT * FROM dormitories,dormitory_builds WHERE dormitories.d_id='{$students['d_id']}' AND dormitories.db_id=dormitory_builds.db_id";
                                $users_stu_current_dor_result = mysqli_query($conn,$users_stu_current_dor_query) or die ('SQL语句有误：' . mysqli_error($conn));
                                $users_stu_current_dor = mysqli_fetch_array($users_stu_current_dor_result);*/
                                $user_stu_current_dor_query=mysqli_query($conn,"SELECT * FROM dormitory,build WHERE dormitory.Build_Id='{$student['Dor_Id']}' AND dormitory.Build_Id=Build.Build_Id");
                                $users_stu_current_dor=mysqli_fetch_array($user_stu_current_dor_query);
                                ?>
                                <td><span class="am-badge am-badge-secondary"><?php echo $user_stu_current_dor_build['Build_Name']?></span></td>
                                <td><?php echo $users_stu_current_dor['Dor_No']?></td>
                                <td><?php echo $student['Dor_DedNum']?></td>

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