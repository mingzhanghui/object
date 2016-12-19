<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/23/16
 * Time: 3:15 PM
 */
include '../../public/dbconnect.php';
include "../public/function.php";

//echo "<pre>";
//var_dump($_POST);
//var_dump($_FILES);

if ($_POST) {
  $arr = $_POST;
  if ($_FILES['pic']) {
    $arr['pic'] = upload($_FILES['pic']);
    if ($arr['pic'] === false) {
//      die('图片上传失败');
    }
  }
  $arr = array_filter($arr);
  while (list($key, $value) = each($arr)) {
    $value = htmlspecialchars($value);
    $value = addslashes($value);
    // 每个单引号替换为２个单引号
    $value = str_replace("'", "''", $value);
    // $value = $link->real_escape_string($value);
  }
  $fields = "`" . implode("`,`", array_keys($arr)) . "`";
  $values = "'" . implode("','", $arr) . "'";
  $sql = "insert into link(" . $fields . ") values (" . $values . ")";

  $res = $link->query($sql);
  if (TRUE === $res) {
    $link->close();
    echo "<script>window.location.href='link.php'</script>";
  } else {
    printf("添加友情链接失败(%d): %s<br />[SQL]: %s", $link->errno, $link->error, $sql);
    if (isset($arr['pic'])) {
      unlink($arr['pic']);
    }
  }
  $link->close();
}
