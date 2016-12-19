<?php
session_start();
/* echo "<pre>";
 * print_r($_SESSION); */
session_destroy();
$_SESSION = array();
$_SESSION['isLogin'] = 0;
echo "<script>window.location.href='./login.php'</script>";
?>
