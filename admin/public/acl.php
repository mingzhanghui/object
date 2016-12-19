<?php
include_once __DIR__ . "/../../public/config.php";

session_start();

if (!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] !== 1) {
  header("Location: {$domain}/admin/login.php");
}
?>
