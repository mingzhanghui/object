<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/23/16
 * Time: 3:15 PM
 */

if (!isset($_POST)) {
  die("没有收到POST过来的添加评论数据");
}

include "./public/dbconnect.php";

$comment = array_filter($_POST);
// 分类名称，　用于跳转回去到文章详情页面
$classname = $comment['classname'];
unset($comment['classname']);
//　文章分类ID
$artid = intval($comment['artid']);
//　文章评论时间戳
$comment['replyTime'] = time();

while (list($key, $value) = each($comment)) {
  $value = htmlspecialchars($value);
  $value = addslashes($value);
  $value = $link->real_escape_string($value);
}
// 每个单引号替换为２个单引号
$comment['replyContent'] = str_replace("'", "''", $comment['replyContent']);

$fields = "`" . implode("`,`", array_keys($comment)) . "`";
$values = "'" . implode("','", $comment) . "'";
$sql = "INSERT INTO `comment`(" . $fields . ") VALUES (" . $values . ")";

$res = $link->query($sql);
if ($res == TRUE) {
  echo "<script>";
  echo "location.href='./article.php?artid={$artid}&classname={$classname}#comment_top'";
  echo "</script>";
 } else {
  printf("添加评论失败(%d): %s<br />[SQL]: %s", $link->errno, $link->error, $sql);
}

$link->close();