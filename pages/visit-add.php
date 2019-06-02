<?php
require 'connect/database.php';//链接数据库
require 'include/checklogin.php';
include 'tools/tool_database.php';

$add = $_POST['add'];
$u_no = $_POST['user-no'];
$u_name = $_POST['user-name'];
$u_password = $_POST['user-password'];
$u_password_repeat = $_POST['user-password-repeat'];
$stu_sex = $_POST['user-sex'];
$stu_age = $_POST['user-age'];
$stu_department = $_POST['user-department'];
$stu_grade = $_POST['user-grade'];
$stu_phone = $_POST['user-phone'];
//$stu_dor_build = $_POST['user-dor-build'];
$stu_dor_build = $_GET['db_name_select'];//修复当from=dorlist时，select的disable属性为disabled导致的$stu_dor_build为空，使得添加数据失败
$stu_dor = $_POST['user-dor'];
$stu_bed = $_POST['user-bed'];
$stu_bed = $_POST['user-bed'];
$stu_dor_build_id = queryDorBuildIdByName($conn,$stu_dor_build);

//查询 所有学生的学号
$stu_all_no_query = "SELECT Id FROM user WHERE Power = 3";
$stu_all_no_result = mysqli_query($conn, $stu_all_no_query) or die('SQL语句有误：' . mysqli_error($conn));
$stu_all_no = mysqli_fetch_array($stu_all_no_result);

// 查询 所有的宿舍楼名
$users_all_dor_builds_query = "SELECT Build_Name FROM build ORDER BY Build_Id";
$users_all_dor_builds_result = mysqli_query($conn,$users_all_dor_builds_query) or die ('SQL语句有误：' . mysqli_error($conn));
//$users_all_dor_builds = mysqli_fetch_array($users_all_dor_builds_result);
$users_all_dor_build_query = "SELECT Build_Name,Build_Id FROM build ORDER BY Build_Id";
$users_all_dor_build_result = mysqli_query($conn,$users_all_dor_build_query) or die ('SQL语句有误：' . mysqli_error($conn));
$users_all_dor_build = mysqli_fetch_array($users_all_dor_build_result);

//查询 用户的数量
$users_all_number = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM user"));

// 查询 该楼的所有宿舍号
$dor_build_select_name = $_GET['db_name_select'];
$dor_build_select_id = "1";
if (isset($dor_build_select_name)) {
    $dor_build_select_id = queryDorBuildIdByName($conn,$dor_build_select_name);
    $dor_list_query = "SELECT Dor_No FROM dormitory WHERE Build_Id='$dor_build_select_id'";
} else $dor_list_query = "SELECT Dor_No FROM dormitory WHERE Build_Id='{$users_all_dor_build['Build_Id']}'";
$dor_list_result = mysqli_query($conn,$dor_list_query) or die ('SQL语句有误：' . mysqli_error($conn));

$as_add = $_POST['as_save'];
$new_no = $_POST['visit-no'];
$new_build = $_POST['visit-build-no'];
$new_dor = $_POST['visit-dor-no'];
$new_reason = $_POST['visit-reason'];
$new_in = $_POST['visit-in'];
$new_out = $_POST['visit-out'];



/* 添加 记录 */
if ($as_add != "") {
    if ($new_build == "") {
        echo "<script>alert('访问宿舍楼 不能为空！');history.back()</script>";
        exit ();
    }
    if ($new_dor == "") {
        echo "<script>alert('访问宿舍号 不能为空！');history.back()</script>";
        exit ();
    }
    if ($new_reason == "") {
        echo "<script>alert('访问原因 不能为空！');history.back()</script>";
        exit ();
    }
    if ($new_in == "") {
        echo "<script>alert('来访时间 不能为空！');history.back()</script>";
        exit ();
    }
    if ($new_out == "") {
        echo "<script>alert('离开时间 不能为空！');history.back()</script>";
        exit ();
    }
    echo "<script>console.log($as_add);</script>";
    echo "<script>console.log($new_no);</script>";
    echo "<script>console.log($new_build);</script>";
    echo "<script>console.log($new_dor);</script>";
    echo "<script>console.log($new_reason);</script>";
    echo "<script>console.log($new_in);</script>";
    echo "<script>console.log($new_out);</script>";
    echo "<script>console.log('我在哪，我是谁，我在干嘛');</script>";
    mysqli_query($conn,"INSERT INTO dor_visit (Stu_No, Apart_No, Dor_No, Visit_Reason, Visit_In, Visit_Out) VALUES ('$new_no','$new_build','$new_dor','$new_reason','$new_in','$new_out')") or die('SQL语句有误：' . mysqli_error($conn))
    or die ('SQL语句有误：' . mysqli_error($conn));
    echo "<script>alert('来访信息添加成功！');location.href='?r=show-visit'</script>";
}

?>

<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>新增来访</title>
    <meta name="description" content="这是一个 user 页面">
    <meta name="keywords" content="user">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
    <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
    以获得更好的体验！</p>
<![endif]-->

<!-- header start -->
<header class="am-topbar am-topbar-inverse admin-header">
    <?php require 'tools/header.php'; ?>
</header>
<!-- header end -->

<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php require 'tools/siderbar.php'; ?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">添加来访记录</strong> /
                    <small>Add Visit</small>
                </div>
            </div>

            <hr/>

            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8"></div>

                <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                    <form class="am-form am-form-horizontal" method="post" name="edit" >

                        <div class="am-form-group">
                            <label for="admin-no-super" class="am-u-sm-3 am-form-label">来访学号</label>
                            <div class="am-u-sm-9">
                                <?php
                                // 判断 用户权限，是否可编辑
                                if ($user_power == 3 || $page_from == "dorlist") {
                                    echo "<select name='visit-no' id='visit-no' disabled='disabled' onchange='request(this.id)'>";
                                } else {
                                    echo "<select name='visit-no' id='visit-no' onchange='request(this.id)'>";
                                }
                                // 把 所有宿舍楼 遍历到数组中，输出
                                while ($stu_all_no = mysqli_fetch_array($stu_all_no_result)) {
                                    if ($stu_all_no['Id'] == '2017100') {
                                        echo "<option value='{$stu_all_no['Id']}' selected='selected'>{$stu_all_no['Id']}</option>";
                                    } else {
                                        echo "<option value='{$stu_all_no['Id']}'>{$stu_all_no['Id']}</option>";
                                    }
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="admin-no-super" class="am-u-sm-3 am-form-label">访问宿舍楼</label>
                            <div class="am-u-sm-9">
                                    <?php
                                    // 判断 用户权限，是否可编辑
                                    if ($user_power == 3 || $page_from == "dorlist") {
                                        echo "<select name='visit-build-no' id='visit-build-no' disabled='disabled' onchange='request(this.id)'>";
                                    } else {
                                        echo "<select name='visit-build-no' id='visit-build-no' onchange='request(this.id)'>";
                                    }
                                    // 把 所有宿舍楼 遍历到数组中，输出
                                    while ($dor_builds = mysqli_fetch_array($users_all_dor_builds_result)) {
                                        if ($dor_builds['Build_Name'] == 'C1') {
                                            echo "<option value='{$dor_builds['Build_Name']}' selected='selected'>{$dor_builds['Build_Name']}</option>";
                                        } else {
                                            echo "<option value='{$dor_builds['Build_Name']}'>{$dor_builds['Build_Name']}</option>";
                                        }
                                    }
                                    echo "</select>";
                                    ?>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="admin-name-super" class="am-u-sm-3 am-form-label">访问宿舍号</label>
                            <div class="am-u-sm-9">
                                <?php
                                // 判断 用户权限，是否可编辑
                                if ($user_power == 3) {
                                    echo "<select name='visit-dor-no' disabled='visit-dor-no'>";
                                } else {
                                    echo "<select name='visit-dor-no'>";
                                }
                                // 把该宿舍楼的 所有宿舍号 遍历到数组中，输出
                                while ($db_dor = mysqli_fetch_array($dor_list_result)) {
                                    if ($db_dor['Dor_No'] == '101') {
                                        echo "<option value='{$db_dor['Dor_No']}' selected='selected'>{$db_dor['Dor_No']}</option>";
                                    } else {
                                        echo "<option value='{$db_dor['Dor_No']}'>{$db_dor['Dor_No']}</option>";
                                    }
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>

                        <div class="am-form-group" <?php if ($user_power != 1) echo 'style="display: none;"' ?>>
                            <label for="admin-password-super-new" class="am-u-sm-3 am-form-label">访问原因</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="visit-reason" name="visit-reason"
                                       placeholder="若修改访问原因；">
                            </div>
                        </div>

                        <div class="am-form-group" <?php if ($user_power != 1) echo 'style="display: none;"' ?>>
                            <label for="admin-password-super-repeat" class="am-u-sm-3 am-form-label">来访时间</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="visit-in"
                                       name="visit-in"
                                       placeholder="若修改来访时间；">
                            </div>
                        </div>

                        <div class="am-form-group" <?php if ($user_power != 1) echo 'style="display: none;"' ?>>
                            <label for="admin-password-super-repeat" class="am-u-sm-3 am-form-label">离开时间</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="visit-out"
                                       name="visit-out"
                                       placeholder="修改离开时间；">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <!--                                <button type="submit" name="submit" value="yes" class="am-btn am-btn-primary">保存修改</button>-->
                                <input type="submit" name="as_save" value="保存记录"
                                       class="am-btn am-btn-primary" <?php if ($user_power != 1) echo 'style="display: none;"' ?>>
                                <!--                                <input type="submit" name="forget" value="忘记密码 ^_^? " class="am-btn am-btn-default am-btn-sm am-fr">-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="admin-content-footer">
            <?php require 'tools/footer.php'; ?>
        </footer>

    </div>
    <!-- content end -->

</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu"
   data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<footer>
    <?php require 'tools/footer.php'; ?>
</footer>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
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
