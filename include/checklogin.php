<?php
// 获得 登录 所存放的cookie值
$user = $_COOKIE ['user'];
$user_power = $_COOKIE ['user_power'];
$user_no = null;


//判断是否登陆
if($user == ""){
    //重定向到登陆页面
    header("Location: ?r=login");
    exit();
}else{
    $query = "SELECT * FROM user WHERE Id = '$user'";
    $result = mysqli_query($conn, $query);
    $users = mysqli_fetch_array($result);

    //查找到用户的信息，并储存
    switch ($user_power){
        case 1:
            $username = "超管：" . $users ['UserName'];
            $user_no = $users ['Id'];
            $user_name = $users ['UserName'];
            break;

        case 2:
            $username = "普管 : {$users ['UserName']}：" . $users ['Id'];
            $user_no = $users ['Id'];
            $user_name = $users ['UserName'];
            break;

        case 3:
            $username = "学生 : {$users ['UserName']}：" . $users ['Id'];
            $user_no = $users ['Id'];
            $user_name = $users ['UserName'];
            break;

        default:break;
    }
}
?>
