<?php
if (!$_POST) {
  die('没有接收到$_POST');
}

include '../../public/dbconnect.php';
include '../public/function.php';

//echo "<pre>";
//var_dump($_POST);
//var_dump($_FILES);
// 将数组中false, null, ''的值排除掉
$article = array_filter($_POST);

$article['classid'] = intval($article['classid']);
$article['title'] = $link->real_escape_string($article['title']);
$article['author'] = $link->real_escape_string(isset($article['author']) ? $article['author'] : '未知作者');
$article['content'] = htmlspecialchars(
    $link->real_escape_string(isset($article['content']) ? $article['content'] : '空内容') );
$article['time'] = time();
if ($_FILES) { $article['pic'] = upload($_FILES['pic']); }
$article['recommend'] = intval($article['recommend']);

$fields = implode(",", array_keys($article));
$values = "'" .implode("','", $article) . "'";
/* 插入文章 */
$sql = "INSERT INTO article(" . $fields . ") VALUES(" . $values . ")";
$res = $link->query($sql);

if ($res == TRUE) {
  echo "<script>window.location.href='./article.php'</script>";
} else {
  // echo "<script>window.location.href='./addArticle.php'</script>";
  // 插入数据库失败， 删除上传的缩略图
  unlink($_SERVER['DOCUMENT_ROOT'] . 'upload/' . $article['pic']);
  echo $link->error;
}
$stmt->close();
unset($article);
$link->close();
?>
