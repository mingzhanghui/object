<?php
/* echo $_POST['emailOrMobile'].'<br />';
 * echo $_POST['nickname'].'<br />';
 * echo $_POST['password'].'<br />';
 * echo $_POST['captcha_code'].'<br />';*/

session_start();
$postCode = $_POST['captcha_code'];
$code = $_SESSION['captcha_code'];
if (strtolower($postCode) != strtolower($code)) {
  echo "<script>alert('验证码错误！'); location.href='member.php'</script>";
}
if (!isset($_POST['emailOrMobile']) || !isset($_POST['nickname'])
  || !isset($_POST['password'])) {
  exit;    /* 只有表单每项都填写了才执行下面的代码 */
}

// 连接数据库 返回$link
include_once('../public/dbconnect.php');

$email = $mobile = '';

$emailOrMobile = $_POST['emailOrMobile'];
if (preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $emailOrMobile)) {
  $email = $emailOrMobile;
  $mobile = '';
} else if (preg_match('/^(\+86)?1[358][0-9]{9}$/', $emailOrMobile)) {
  $email = '';
  $mobile = $emailOrMobile;
}

$username = $_POST['nickname'];
$password = md5($_POST['password']);

/* isAdmin 默认1, 不是管理员 */
$sql = "INSERT INTO user(username, pwd, mobile, email, isAdmin)
        VALUES('{$username}', '{$password}', '{$mobile}', '{$email}', 1)";

$result = $link->query($sql);
if (!$result) {
  echo 'Could not run query: ' . $link->error();
  exit;
}
if ($link->affected_rows > 0) {
  echo "<script>alert('注册成功!'); location.href='login.php';</script>";
} else {
  echo "<script>alert('注册失败'); location.href='resiter.php';</script>";
}

$link->close();

// unset($_SESSION["captcha_code"]);
$_SESSION["captcha_code"] = null;
session_destroy();

?>
