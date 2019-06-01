<?php

require 'connect/database.php';//链接数据库
require 'include/checklogin.php';
include 'tools/tool_database.php';

/**
 * 根据传进来的 编号NO 删除用户
 */
$delete_no = $_GET ['delete_no'];
$isDelete = $_GET['isdelete'];
$page_from = $_GET['from'];
if ($delete_no != "" && $isDelete == "true") {
    if ($user_power != 1) {
        echo "<script>alert('权限不足！！');location.href='?r=$page_from';</script>";
        exit();
    }
    $dor_num_now_id = queryDorStuNumNowAndIdByUserNo($conn, $delete_no);
    $dor_num_now = $dor_num_now_id['Dor_Person'] - 1;
    mysqli_query($conn, "UPDATE dormitory SET Dor_Person='$dor_num_now' WHERE Dor_Id='{$dor_num_now_id['Dor_Id']}'") or die ('SQL语句有误：' . mysqli_error($conn));
    $delete_query1 = "DELETE FROM student WHERE Stu_No='$delete_no'";
    $delete_query2 = "DELETE FROM user WHERE Id='$delete_no'";
    mysqli_query($conn, $delete_query1) or die ('删除错误' . mysqli_error($conn));
    mysqli_query($conn, $delete_query2) or die ('删除错误' . mysqli_error($conn));
    echo "<script>alert('学号为 " . $delete_no . "的学生已删除');location.href='?r=$page_from';</script>";
}