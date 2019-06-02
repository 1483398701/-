<?php
require 'connect/database.php';//链接数据库
require 'include/checklogin.php';
include 'tools/tool_database.php';

$edit_target = $_GET['edit_target'];
$sno = $_GET['sno'];
$target_no = $_GET['tno'];

//查询 当前学号访问的记录
$stu_visit_query = "SELECT * FROM dor_visit WHERE Stu_No = $sno";
$stu_visit_result = mysqli_query($conn, $stu_visit_query) or die ('SQL语句有误：' . mysqli_error($conn));
$stu_visit = mysqli_fetch_array($stu_visit_result);

echo "<script>console.log(111);</script>";

$as_save = $_POST['as_save'];
$new_build = $_POST['visit-build-no'];
$new_dor = $_POST['visit-dor-no'];
$new_reason = $_POST['visit-reason'];
$new_in = $_POST['visit-in'];
$new_out = $_POST['visit-out'];

echo "<script>console.log($new_build);</script>";
echo "<script>console.log($new_dor);</script>";
echo "<script>console.log($new_reason);</script>";

/* 修改 信息 */
if ($as_save != "") {

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
    mysqli_query($conn,"UPDATE dor_visit SET Apart_No = '$new_build', Dor_No = '$new_dor', Visit_Reason = '$new_reason', Visit_In = '$new_in', Visit_Out = '$new_out' WHERE Stu_No='$sno'")
                    or die ('SQL语句有误：' . mysqli_error($conn));
    echo "<script>alert('信息添加成功！');location.href='?r=show-visit'</script>";
}

?>

<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>来访记录</title>
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
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">个人资料</strong> /
                    <small>Personal information</small>
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
                                <input type="text" id="visit-sno" name="visit-sno" placeholder="请输入来访人员的学号"
                                       readonly="true"
                                       value="<?php echo $sno ?>">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="admin-name-super" class="am-u-sm-3 am-form-label">访问宿舍楼</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="visit-build-no" name="visit-build-no" placeholder="请输入访问的宿舍楼"
                                       value="<?php echo $stu_visit['Apart_No'] ?>" <?php if ($user_power != 1) echo 'readonly="true"' ?>>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="admin-name-super" class="am-u-sm-3 am-form-label">访问宿舍号</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="visit-dor-no" name="visit-dor-no" placeholder="请输入访问的宿舍号"
                                       value="<?php echo $stu_visit['Dor_No'] ?>" <?php if ($user_power != 1) echo 'readonly="true"' ?>>
                            </div>
                        </div>

                        <div class="am-form-group" <?php if ($user_power != 1) echo 'style="display: none;"' ?>>
                            <label for="admin-password-super-new" class="am-u-sm-3 am-form-label">访问原因</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="visit-reason" name="visit-reason"
                                       value="<?php echo $stu_visit['Visit_Reason'] ?>"
                                       placeholder="若修改访问原因；否则忽略该项不填">
                            </div>
                        </div>

                        <div class="am-form-group" <?php if ($user_power != 1) echo 'style="display: none;"' ?>>
                            <label for="admin-password-super-repeat" class="am-u-sm-3 am-form-label">来访时间</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="visit-in"
                                       name="visit-in"
                                       value="<?php echo $stu_visit['Visit_In'] ?>"
                                       placeholder="若修改来访时间；否则忽略该项不填">
                            </div>
                        </div>

                        <div class="am-form-group" <?php if ($user_power != 1) echo 'style="display: none;"' ?>>
                            <label for="admin-password-super-repeat" class="am-u-sm-3 am-form-label">离开时间</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="visit-out"
                                       name="visit-out"
                                       value="<?php echo $stu_visit['Visit_Out'] ?>"
                                       placeholder="若修改离开时间；否则忽略该项不填">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <!--                                <button type="submit" name="submit" value="yes" class="am-btn am-btn-primary">保存修改</button>-->
                                <input type="submit" name="as_save" value="保存修改"
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
