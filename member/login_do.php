<script type="text/javascript" src="../js/getCookie.js"></script>
<?php
include_once('../public/dbconnect.php');
include_once('../public/config.php');

/* 开始session，保存用户登录名 */
session_start();

/* 定义变量并设置为空值 */
$username = $password = $email = $mobile = '';

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

/* 用户基本信息写入session */
function userToSession($link, $id) {
  $sql = "select id,username,pwd,email,mobile,sex,info,pic from user where id={$id}";
  $result = $link->query($sql);
  if (!$result) {
    printf("No such user id: %s\nsql: %s", $id, $sql);
    return false;
  }
  $row = $result->fetch_array(MYSQLI_ASSOC);
  $_SESSION['user'] = $row;
  unset($row);
  return true;
}

/* 表单提交之后执行操作 */
if ($_POST) {
  $_username = test_input($_POST['_username']);
  $password = md5(test_input($_POST['password']));

  if (preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $_username)) {
    /* 通过邮箱名登录 */
    $email = $_username;
    $sql = "SELECT `id`,`pwd` FROM `user` WHERE `email`='{$email}'";
  } else if (preg_match('/^(\+86)?1[358][0-9]{9}$/', $_username)) {
    /* 通过手机号码登录 */
    $mobile = $_username;
    $sql = "SELECT `id`,`pwd` FROM `user` WHERE `mobile`='{$mobile}'";
  } else {
    /* 通过用户名登录 */
    $username = $_username;
    $sql = "SELECT `id`,`pwd` FROM `user` WHERE `username`='{$username}'";
  }

  $result = $link->query($sql, MYSQLI_STORE_RESULT);
  if (!$result) {
    echo "Could not successfully run query ($sql) from DB: " . $link->error;
    exit;
  }

  $row = NULL;
  if ($row = $result->fetch_row()) {
    if (strcmp($password, $row[1]) === 0) {
      /* 用户名写入session */
      $_SESSION['login'] = $username;
      /* 通过用户ID把用户基本信息写入session */
      userToSession($link, $row[0]) || die;
      // 跳转回登录之前的页面
      if (!empty($_COOKIE['referer'])) {
//        echo $_COOKIE['referer'];
        echo "<script>alert('登录成功!'); location.href=getCookie('referer')</script>";
      }
      echo "<script>alert('登录成功!'); location.href=\"../index.php\"</script>";
    } else {
      echo "<script>alert('密码不正确'); location.href='login.php'</script>";
    }
  } else {
    echo "<script>alert('用户名不存在!'); location.href='login.php'</script>";
  }
  $result->free();
  $link->close();
}

?>
