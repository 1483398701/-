<?php
/**
 * Created by PhpStorm.
 * User: LunZi
 * Date: 2019/4/28
 * Time: 17:00
 */
require 'connect/database.php';//链接数据库
require 'include/checklogin.php';

$visit_query = mysqli_query($conn, "SELECT * FROM dor_visit ORDER BY Stu_No DESC LIMIT 15");

//分页：http://www.runoob.com/w3cnote/php-mysql-pagination.html
$num_rec_per_page = 10;   // 每页显示数量
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $num_rec_per_page;

?>

<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>超级管理员列表</title>
    <meta name="description" content="这是一个 table 页面">
    <meta name="keywords" content="table">
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
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">来访记录</strong> /
                    <small>Visit</small>
                </div>
            </div>

            <hr>

            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-6" <?php if ($user_power == 3) echo 'style="display: none;"' ?>>
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button id="bt_add_visit" type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增
                            </button>
                            </button>
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span>
                                批量删除
                            </button>
                        </div>
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" class="am-form-field">
                        <span class="am-input-group-btn">
            <button class="am-btn am-btn-default" type="button">搜索</button>
          </span>
                    </div>
                </div>
            </div>

            <div class="am-g">
                <div class="am-u-sm-12 table-container">
                    <table class="am-table am-table-bd am-table-striped admin-content-table">
                        <thead>
                        <tr>
                            <th>来访学号</th>
                            <th>访问宿舍楼</th>
                            <th>访问宿舍号</th>
                            <th>访问原因</th>
                            <th>来访时间</th>
                            <th>离开时间</th>
                            <th>管理</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        // 结果集遍历到数组
                        while ( $visit = mysqli_fetch_array ( $visit_query ) ) {
                            ?>
                            <tr>
                                <td><?php echo $visit['Stu_No']?></td>
                                <td><?php echo $visit['Apart_No']?></td>
                                <td><?php echo $visit['Dor_No']?></td>
                                <td><?php echo $visit['Visit_Reason']?></td>
                                <td><?php echo $visit['Visit_In']?></td>
                                <td><?php echo $visit['Visit_Out']?></td>
                                <td>
                                    <div class="am-dropdown" data-am-dropdown>
                                        <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>
                                        <ul class="am-dropdown-content">
                                            <li><a href="?r=user-visit&sno=<?php echo $visit['Stu_No'] ?>&edit_target=<?php if ($visit['Stu_No'] == $user_no) echo "self"; else echo "others"; ?>">1. 编辑</a></li>
                                            <li><a href="?r=visit-delete&delete_no=<?php echo $visit['Stu_No'] ?>&isdelete=true&from=index" onclick="return confirm('删除后无法恢复数据，是否继续？');">2. 删除</a></li>
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

        <footer class="admin-content-footer">
            <?php require 'tools/footer.php'; ?>
        </footer>

    </div>
    <!-- content end -->
</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu"
   data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

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

<script type="text/javascript">

    $(function () {
        $("#bt_add_visit").click(function () {
            window.location.href = '?r=visit-add';
        });
        $("#bt_del").click(function () {
            window.location.href = '#';
        });
    });
</script>

</body>
</html>
