<?php
if (!$_POST) {
  die('没有得到$_POST数据');
}
include ('../../public/dbconnect.php');
include ('../public/function.php');

$article = array_filter($_POST);

// page, classid用于修改成功跳转到article.php的get参数
if (isset($article['page'])) {
  $page = intval($article['page']);
  unset($article['page']);   // page字段不插入数据库
}
$classid = intval($article['classid']);

/* 更新文章更改时间 */
$article['time'] = time();
/* 上传文章缩略图 */
$oldPic = "";
if ($_FILES['pic']['name']) {
  $article['pic'] = upload($_FILES['pic']);
  $oldPic = '../../uploads/' . $article['oldPic'];
}
unset($article['oldPic']);
/* id不在set子句的字段中 */
$id = intval($article['id']);
unset($article['id']);

/* 构造SET子句字符串 */
$str = "";
foreach ($article as $key => $value) {
  /* mysql插入数据的问题 特殊字符' */
  $value = $link->real_escape_string($value);
  $str .= $key . "='" . $value . "',";
}
$str = rtrim($str, ',');

$sql = "UPDATE `article` SET {$str} WHERE id={$id}";

$res = $link->query($sql);
if ($res === TRUE) {
  /* 删除旧的图片 */
  if ($_FILES['pic']['name']) {
    file_exists($oldPic) && unlink($oldPic);
  }
  $url = sprintf("article.php?page=%d&classid=%d", $page, $classid);
  header("Location: {$url}");
} else {
  printf("修改文章失败! ERRNO: %d %s\n", $link->errno, $link->error);
  echo $sql;
}
unset($article);
$link->close();

?>
