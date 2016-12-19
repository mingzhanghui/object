<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 11/1/16
 * Time: 9:50 AM
 */
session_start();

if (!isset($_POST)) {
  die("没有设置replyComment.php POST");
}

include '../../public/dbconnect.php';

$reply = array_filter($_POST);
if (!isset($reply['id']) || !isset($reply['replyContent'])) {
  var_dump($_POST);
  die('没有设置评论ID或评论内容');
}
// 回复类型 1-评论 2-回复
$reply['replyType'] = 2;
// 被回复的评论ID
$reply['replyId'] = $reply['id'];
// 新的评论ID由数据库自增产生
unset($reply['id']);
// 回复的时间戳
$reply['replyTime'] = time();
// 当前登录后台管理的管理员用户ID
$reply['replyUserID'] = $_SESSION['master']['id'];

// 字符串安全处理
while (list($key, $value) = each($reply)) {
  $value = htmlspecialchars($value);
  $value = addslashes($value);
}
$reply['replyContent'] = str_replace("'", "''", $reply['replyContent']);

$fields = "`" . implode("`,`", array_keys($reply)) . "`";
$values = "'" . implode("','", $reply) . "'";

$sql = sprintf("INSERT INTO `comment`(%s) VALUES(%s)", $fields, $values);
$res = $link->query($sql);
if ($res == TRUE) {
  echo "<script>window.location.href='comment.php'</script>";
} else {
  printf("回复评论失败(%d): %s<br />[SQL]: %s",
    $link->errno, $link->error, $sql);
  echo "<pre>";
  var_dump($reply);
}
$link->close();
