<script type="text/javascript" src="../js/getCookie.js"></script>
<?php
session_start();

session_destroy();
$_SESSION = array();
$_SESSION['login'] = null;
$_SESSION['user'] = null;
unset($_SESSION['login']);
unset($_SESSION['user']);

// 登录前访问的页面URL
if (!empty($_COOKIE['referer'])) {
  echo "<script>window.location.href=getCookie('referer')</script>";
} else {
  echo "<script>window.location.href='./login.php'</script>";
}

?>
