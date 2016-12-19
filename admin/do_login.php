<?php
session_start();
include ("../public/dbconnect.php");

if ($_POST) {
  $user = $_POST;
  $user['pwd'] = md5($user['pwd']);

  $sql = "SELECT * FROM `user` WHERE `username` = '{$user['username']}' AND `pwd` = '{$user['pwd']}' AND isAdmin = 2";
  $res = $link->query($sql);
  $master = $res->fetch_assoc();
  if ($master) {
    $_SESSION['master'] = $master;
    $_SESSION['isLogin'] = 1;
    echo "<script>window.location.href='./index.php'</script>";
  } else {
    echo "<script>alert('请输入正确的用户名和密码')</script>";
    echo "<script>window.history.back()</script>";
  }
  $res->free();
}
$link->close();

?>
