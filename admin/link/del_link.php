<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/23/16
 * Time: 3:15 PM
 */
include_once '../../public/config.php';
include '../public/acl.php';
include '../../public/dbconnect.php';

if (isset($_GET) && isset($_GET['id'])) {
  $id = intval($_GET['id']);
  // 删除友情链接LOGO
  $sql ="SELECT pic FROM `link` WHERE id={$id}";
  if (($res = $link->query($sql)) == null) {
    echo "查找logo文件名失败 - ($sql) : " . $link->error;
    exit;
  }
  $row = $res->fetch_array(MYSQLI_ASSOC);
  // 用户上传过logo
  if ($row) {
    // $path = $_SERVER['DOCUMENT_ROOT'] . 'object/uploads/' . $row['pic'];
    $path = realpath('../../uploads/' . $row['pic']);
    unlink($path);
  }
  $sql = "delete from link where id={$id}";
  if ($link->query($sql)) {
    echo "<script>location.href='link.php'</script>";
  }
}