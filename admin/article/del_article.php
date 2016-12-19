<?php 
include ('../../public/dbconnect.php');

$id = $_GET['id'];

// 删除用户头像图片文件
$sql ="SELECT pic FROM `article` WHERE id={$id}";
$res = $link->query($sql);
if ($res == null) {
  echo "查找用户头像文件名失败 - ($sql) : " . $link->error;
  exit;
}
$row = $res->fetch_array(MYSQLI_ASSOC);
// 用户上传过文章缩略图
if ($row) {
  $path = realpath('../../uploads/' . $row['pic']);
  unlink($path);
  unset($row);
}

$sql = "DELETE FROM `article` WHERE `id`={$id}";
if ($link->query($sql) == TRUE) {
 //  跳转到上次页面./article.php?id=xxx&page=xxx
  // header("Location: " . $_SERVER['HTTP_REFERER']);
  echo "<script>history.go(-1)</script>";
} else {
  echo "Error deleting record: ". $link->error;
}
$link->close();

?>
