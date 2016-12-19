<?php
session_start();

if (!isset($_SESSION['captcha_code'])) {
  $_SESSION['captcha_code'] = "";
}

/* 比较SESSION中的验证码值和表单提交的验证码值 */
$code = $_SESSION['captcha_code'];
/* 如果收到来自register.php用户输入的验证码 */
if (isset($_POST['captcha_code'])) {
  $postCode = $_POST['captcha_code'];
  if ($postCode === "") {
    echo "请输入验证码";
  } else {
    if (strtolower($postCode) == strtolower($code)) {
       echo "true";
    } else {
      /* echo 'post: '.$postCode;
       * echo 'session: '.$code;*/
      echo "<font color='red'>验证码错误! </font>";
    }
  }
} else {
  echo "post code is not set!";
}

?>
