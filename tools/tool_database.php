<?php

function queryPasswordByUno($conn, $Id)
{
    $users_query = "SELECT Password FROM user WHERE Id='$Id' ORDER BY Id DESC";
    $users_result = mysqli_query($conn,$users_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $users = mysqli_fetch_array($users_result);
    return $users['Password'];
}

function queryDorBuildNameById($conn, $dor_id)
{
    $db_query = "SELECT Build_Name FROM build WHERE Build_Id='$dor_id' ORDER BY Build_Id";// 检索记录行 $start_from - ($start_from+15)
    $db_result = mysqli_query($conn,$db_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $db = mysqli_fetch_array($db_result);
    return $db['Build_Name'];
}

function queryDorBuildPriceById($conn, $dor_id)
{
    $dor_build_query = "SELECT Build_Price FROM build WHERE Build_Id='$dor_id' ORDER BY Build_Id";
    $dor_build_result = mysqli_query($conn,$dor_build_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $dor_build = mysqli_fetch_array($dor_build_result);
    return $dor_build['Build_Price'];
}

function queryNameByUno($conn, $u_no)
{
    $users_query = "SELECT UserName FROM user WHERE Id='$u_no' ORDER BY Id DESC";
    $users_result = mysqli_query($conn,$users_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $users = mysqli_fetch_array($users_result);
    return $users['UserName'];
}

function queryIsSameDorByUserNo($conn, $user_no_1, $user_no_2)
{
    $stu_query_1 = "SELECT Dor_Id FROM student WHERE Stu_No=$user_no_1";
    $stu_result_1 = mysqli_query($conn,$stu_query_1) or die ('SQL语句有误：' . mysqli_error($conn));
    $stu_1 = mysqli_fetch_array($stu_result_1);
    $stu_query_2 = "SELECT Dor_Id FROM student WHERE Stu_No=$user_no_2";
    $stu_result_2 = mysqli_query($conn,$stu_query_2) or die ('SQL语句有误：' . mysqli_error($conn));
    $stu_2 = mysqli_fetch_array($stu_result_2);
    if ($stu_1['Dor_Id'] == $stu_2['Dor_Id']) {
        return true;
    }else return false;
}

function queryIsDorExistByDorNameAndDorBuildId($conn, $db_id, $dor_name)
{
    $dor_query = "SELECT Dor_No FROM dormitory WHERE Build_Id=$db_id AND Dor_No=$dor_name";
    $dor_result = mysqli_query($conn,$dor_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $dor = mysqli_fetch_array($dor_result);
    if ($dor['Dor_No'] != "") {
        return true;
    }else return false;
}

function queryDorBuildIdByName($conn, $db_name)
{
    $dor_build_query = "SELECT Build_Id FROM build WHERE Build_Name='$db_name'";
    $dor_build_result = mysqli_query($conn,$dor_build_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $dor_build = mysqli_fetch_array($dor_build_result);
    return $dor_build['Build_Id'];
}

function queryDorStuNumNowAndIdByUserNo($conn, $user_no)
{
    $dor_num_now_id_query = "SELECT Dor_Id,Dor_Person FROM dormitory WHERE Dor_Id=(SELECT student.Dor_Id FROM student WHERE Stu_No='$user_no')";
    $dor_num_now_id_result = mysqli_query($conn,$dor_num_now_id_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $dor_num_id_now = mysqli_fetch_array($dor_num_now_id_result);
    return $dor_num_id_now;
}

function queryIsUserExistByNo($conn, $u_no)
{
    $users_query = "SELECT Id FROM user WHERE Id='$u_no' ORDER BY Id DESC";
    $users_result = mysqli_query($conn, $users_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $users = mysqli_fetch_array($users_result);
    $stu_query = "SELECT Stu_No FROM student WHERE Stu_No='$u_no' ORDER BY Stu_No DESC";
    $stu_result = mysqli_query($conn, $stu_query) or die ('SQL语句有误：' . mysqli_error($conn));
    $stu = mysqli_fetch_array($stu_result);
    if ($users['Id'] != "" && $stu['Stu_No'] != "") {
        return true;
    } else return false;
}

?>