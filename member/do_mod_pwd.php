<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 11/2/16
 * Time: 10:55 AM
 */
session_start();

if (!$_POST) {
  die('没有POST数据');
}
include "../public/dbconnect.php";

$user = array_filter($_POST);

// 校验原始密码
$id = intval($user['id']);
$sql = "SELECT pwd from user where id={$id}";
$res = $link->query($sql);
if ($res == TRUE) {
  $row = $res->fetch_assoc();
  $oldpwd = $row['pwd'];
} else {
  printf("查询原始密码失败: %s", $link->error);
  exit;
}
if (md5($user['oldpwd']) !== $oldpwd) {
  printf("输入原始密码:[%s], 数据库密码[%s]", md5($user['oldpwd']), $oldpwd);
  die('原始密码输入错误');
}
$res->free_result();

var_dump($user);
// 重新设置的新密码
$pwd = md5($user['pwd']);
$sql = "update user set pwd='{$pwd}' where id={$id}";
$res = $link->query($sql);
if ($res === TRUE) {
  $link->close();
  session_destroy();
  $_SESSION['user'] = array();
  unset($_SESSION['user']);
  echo "<script>location.href='login.php'</script>";
} else {
  printf("重新设置密码失败(%d): %s", $link->errno, $link->error) ;
}
$link->close();




