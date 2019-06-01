<?php
/**
 * Created by PhpStorm.
 * User: LunZi
 * Date: 2019/4/28
 * Time: 17:00
 */
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
<div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
        <ul class="am-list admin-sidebar-list">
            <?php

            // 判断 用户权限，以设置显示的不同页面
            switch ($user_power) {
                case 1 :
                    $judge_href = "?r=superadmin";
                    break;
                case 2 :
                    $judge_href = "?r=normaladmin";
                    break;
                case 3 :
                    $judge_href = "?r=student";
                    break;
            }
            ?>
            <li><a href="<?php echo $judge_href ?>"><span class="am-icon-home"></span> 首页</a></li>
            <?php
            // 判断 用户权限，以设置显示的不同页面
            switch ($user_power) {
                case 1 :
                    $data_href = "?r=user-admin-super&uno={$users['Id']}";
                    break;
                case 2 :
                    $data_href = "?r=user-admin-normal&uno={$users['Id']}&edit_target=self";
                    break;
                case 3 :
                    $data_href = "?r=user-stu&sno={$users['Id']}&edit_target=self";
                    break;
            }
            ?>

            <li><a href="<?php echo $data_href ?>" class="am-cf"><span class="am-icon-check"></span> 个人资料<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>
            <li <?php if ($user_power == 3) echo 'style="display: none;"' ?>><a href="?r=show-visit" class="am-cf"><span class="am-icon-file"></span> 来访记录<span class="am-icon-star am-fr am-margin-right"></span></a></li>
            <li class="admin-parent" <?php if ($user_power == 3) echo 'style="display: none;"' ?>>
                <a class="am-cf" data-am-collapse="{target: '#collapse-nav'}"><span class="am-icon-file"></span> 对象管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav">
                    <li <?php if ($user_power == 2 || $user_power == 3) echo 'style="display: none;"' ?>><a href="?r=show-admin-super"><span class="am-icon-puzzle-piece"></span> 超级管理员 <span class="am-badge am-badge-secondary am-margin-right am-fr"><?php echo $super_admins_count?></span></a></li>
                    <li <?php if ($user_power == 2 || $user_power == 3) echo 'style="display: none;"' ?>><a href="?r=show-admin-normal"><span class="am-icon-th"></span> 普通管理员<span class="am-badge am-badge-secondary am-margin-right am-fr"><?php echo $normal_admins_count?></span></a></li>
                    <li ><a href="?r=show-stu"><span class="am-icon-calendar"></span> 学生 <span class="am-badge am-badge-secondary am-margin-right am-fr"><?php echo $students_count?></span></a></li>
                </ul>
            </li>
            <li <?php if ($user_power != 3) echo 'style="display: none;"' ?>>
                <a href="?r=show-dormitories&db_id=<?php $db = mysqli_fetch_array(mysqli_query($conn,"SELECT Dor_Id FROM dormitory WHERE Build_Id=(SELECT student.Dor_Id FROM student WHERE Stu_No=$user_no) ORDER BY Dor_Id"));  echo $db['Dor_Id']?>" class="am-cf"><span
                            class="am-icon-file"></span> 我的宿舍<span
                            class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a>
            </li>
            <li class="admin-parent" <?php if ($user_power == 3) echo 'style="display: none;"' ?>>
                <a class="am-cf" data-am-collapse="{target: '#collapse-nav'}"><span class="am-icon-file"></span> 宿舍管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav">
                    <?php
                    // 结果集遍历到数组
                    while ($dormitory_builds = mysqli_fetch_array($dormitory_builds_query)) {
                        ?>
                        <li><a href="?r=show-dormitories&db_id=<?php echo $dormitory_builds['Build_Id'] ?>"><span
                                        class="am-icon-table"></span> <?php echo $dormitory_builds['Build_Name'] ?>
                                <span
                                        class="am-badge am-badge-secondary am-margin-right am-fr">共<?php echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM dormitory d,build b WHERE d.Build_Id = b.Build_Id AND b.Build_Name ='{$dormitory_builds['Build_Name']}' ")) ?>
                                    个宿舍</span></a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li><a href="?r=outlogin"><span class="am-icon-sign-out"></span> 注销</a></li>
        </ul>
    </div>
</div>

