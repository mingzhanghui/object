<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 11/1/16
 * Time: 10:03 PM
 */
session_start();

if (!$_POST || !$_FILES) {
  die("没有接收到POST或上传的文件");
}
$user = array_filter($_POST);

include "../public/dbconnect.php";
include "../admin/public/function.php";

// 新上传了头像
if ($_FILES['avatar']['name']) {
  $user['pic'] = upload($_FILES['avatar'], "../uploads");
}
// 旧的头像
$oldPic = '';
if (isset($user['oldPic'])) {
  $oldPic = "../uploads/" . $user['oldPic'];
  unset($user['oldPic']);
}
$id = intval($user['id']);
$pic = $link->real_escape_string($user['pic']);

// $sql = "update user set pic='{$pic}' where id={$id}";
$sql = "update user set pic=? where id=?";
$stmt = $link->prepare($sql);
$stmt->bind_param("si", $pic, $id);
$stmt->execute();
unlink($oldPic);
$stmt->close();
$link->close();
$_SESSION['user']['pic'] = $pic;
echo "<script>location.href='avatar.php'</script>";
