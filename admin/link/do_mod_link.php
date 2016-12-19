<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/23/16
 * Time: 3:16 PM
 */
include ('../../public/dbconnect.php');
include ('../public/function.php');

if ($_POST) {
  $arr = array_filter($_POST);
//  check url
  if (filter_var($arr['siteurl'], FILTER_VALIDATE_URL) === FALSE) {
    die('不是一个有效的网站URL');
  }
//  上传图片
  if ($_FILES['pic']['name']) {
    $arr['pic'] = upload($_FILES['pic']);
  }
//  注销数组中旧图片文件名
  $oldPic = '';
  if (isset($arr['oldPic'])) {
    $oldPic = "../../uploads/" . $arr['oldPic'];
    unset($arr['oldPic']);
  }
//  注销数组中id
  $id = intval($arr['id']);
  unset($arr['id']);

//  拼接sql语句set key='value',
  $str = "";
  foreach ($arr as $key => $value){
    $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
    $value = addslashes($value);
    $str .= $key . "='" . $value . "',";
  }
  $str = rtrim($str, ',');

  $sql = "UPDATE `link` SET {$str} WHERE id={$id}";
  $res = $link->query($sql);
//  插入数据库成功
  if ($res === TRUE) {
//    有旧图片，而且上传了新图片，　删除旧图片
    if (($oldPic != '') && (isset($arr['pic']))) {
      if (file_exists(realpath($oldPic))) {
        unlink($oldPic);
      }
    }
    echo "<script>window.location.href='link.php'</script>";
  }
//  插入数据库失败
  else {
//    上传了图片，但是插入数据库失败，删除新上传的图片
    if (isset($arr['pic'])) {
      $pic = "../../uploads/" . arr['pic'];
      unlink($pic);
    }
    printf("修改友情链接失败[%d]: %s\n", $link->errno, $link->error);
    echo $sql;
    echo "<pre>";
    var_dump($_FILES);
    var_dump($_POST);
  }
  $link->close();
}