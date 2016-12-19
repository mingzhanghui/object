<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/23/16
 * Time: 3:14 PM
 */
if (!isset($_GET)) {
  die("没有GET到任何参数");
}
if (!isset($_GET['id'])) {
  die("没有GET到评论ID");
}

include '../../public/dbconnect.php';

// acl, admin / normal user
$id = $_GET['id'];
$artid = isset($_GET['artid']) ? $_GET['artid'] : '';
$classname = isset($_GET['classname']) ? $_GET['classname'] : '';

$sql = "delete from comment where id={$id}";
$result = $link->query($sql);
if ($result === FALSE) {
  printf("删除评论错误(%d): %s\nSQL: %s", $link->errno, $link->error, $sql);
} else {
  // 后台管理删除评论
  echo "<script>location.href='comment.php'</script>";
}
$link->close();
