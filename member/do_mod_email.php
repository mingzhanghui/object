<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 11/2/16
 * Time: 4:54 PM
 */

include '../public/dbconnect.php';

if ($_POST) {
  if (!isset($_POST['email']) || $_POST['email'] == '') {
    die("没有设置邮箱或邮箱为空");
  }
  $id = intval($_POST['id']);
  $email = $_POST['email'];
  $sql = sprintf("update user set email='%s' where id=%d", $email, $id);
  $res = $link->query($sql);
  if ($res === TRUE) {
    echo "<script>location.href='email.php'</script>";
  }
  $res->free();
}
$link->close();