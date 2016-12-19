<?php
session_start();

if (isset($_SESSION['user'])) {
  echo "<script>location.href='../index.php'</script>";
}

include_once('index.php');
?>

<!-- 切换登录标签 -->
<script type="text/javascript">
var tabs = document.getElementsByClassName('tab');
var contents = document.getElementsByClassName('login-main')[0].getElementsByTagName('form');
/*登录 */
tabs[0].className = 'tab active';
contents[0].className = 'show';
/* 注册 */
tabs[1].className = 'tab';
contents[1].className = '';
</script>

