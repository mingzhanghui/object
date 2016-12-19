<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 11/1/16
 * Time: 8:56 PM
 */
include_once "../public/dbconnect.php";
session_start();

if (isset($_POST)) {
  $user = array_filter($_POST);
  if (isset($_user['id'])) {
    $id = $user['id'];
    unset($user['id']);
  } else {
    $id = $_SESSION['user']['id'];
  }

  $column = '';
  foreach ($user as $key=>$value) {
    $value = htmlspecialchars($value);
    $value = str_replace("'", "''", $value);

    $column .= $key . "='" . $value . "',";
  }
  $column = rtrim($column, ",");
  $sql = sprintf("UPDATE user SET %s WHERE id=%d", $column, intval($id));
  $res = $link->query($sql);
  if ($res == TRUE) {
//    if ($link->affected_rows === 0) {echo ('没有更改');}
    echo "<script>window.location.href='member.php'</script>";
  } else {
    printf("保存用户基本信息错误(%d): %s<br />[SQL]: %s", $link->errno, $link->error, $sql);
  }
}
$link->close();

