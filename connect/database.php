<?php
/**
 * Created by PhpStorm.
 * User: LUNZI
 * Date: 2019/4/23
 * Time: 15:29
 */
//$databaseConnection = null;
//function getConnect() {
$conn = mysqli_connect("localhost","root","","bighomework")or die("连接数据库服务器失败".mysqli_connect_error());
mysqli_query($conn,"set names utf8");