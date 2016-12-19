<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/23/16
 * Time: 3:14 PM
 */
if (!$_POST) {
  die("没有收到POST回复表单thread-subpost-form");
}
include "./public/dbconnect.php";

$reply = array_filter($_POST);
$reply['replyTime'] = time();

while (list(, $value) = each($reply)) {
  $value = htmlspecialchars($value);
  $value = addslashes($value);
  $value = $link->real_escape_string($value);
}
$reply['replyContent'] = str_replace("'", "''", $reply['replyContent']);

$fields = "`" . implode("`,`", array_keys($reply)) . "`";
$values = "'". implode("','", $reply) . "'";
$sql = "INSERT INTO `comment` (" . $fields . ") VALUES(" . $values . ")";

$res = $link->query($sql);
if ($link->affected_rows > 0) {
  $link->close();
  echo "<script>history.go(-1)</script>";
} else {
  printf("回复评论失败(%d): %s<br />[SQL]: %s", $link->errno, $link->error, $sql);
  $link->close();
}

