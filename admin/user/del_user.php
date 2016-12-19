<?php
include ('../../public/dbconnect.php');

$id = $_GET['id'];
// 删除用户头像图片文件
$sql ="SELECT pic FROM `user` WHERE id={$id}";
if (($res = $link->query($sql)) == null) {
  echo "查找用户头像文件名失败 - ($sql) : " . $link->error;
  exit;
}
$row = $res->fetch_array(MYSQLI_ASSOC);
// 用户上传过头像
if ($row) {
  // $path = $_SERVER['DOCUMENT_ROOT'] . 'object/uploads/' . $row['pic'];
  $path = realpath('../../uploads/' . $row['pic']);
  unlink($path);
}

$sql = "DELETE FROM `user` WHERE `id`= {$id}";
if ($link->query($sql) == TRUE) {
  // header("Location: ". $_SERVER['HTTP_REFERER']);
  echo "<script>location.href='user.php'</script>";
} else {
  echo "Error deleting record:" . $link->error;
}

$link->close();

?>
