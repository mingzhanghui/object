<?php 
include ('../../public/dbconnect.php');
include ('../public/function.php');

if ($_POST) {
  if ($_POST['pwd'] || $_POST['repwd']) {
    if ($_POST['pwd'] == $_POST['repwd']) {
      $_POST['pwd'] = md5($_POST['pwd']);
    } else {
      echo "<script>alert('密码与确认密码不一致')</script>";
      echo "<script>window.history.back()</script>";
    }
  }
}
//去掉$_POST值为null, 0, false, ""的键值对
$user = array_filter($_POST);

// 用户上次上传的头像文件名
$oldPic = "";
if ($_FILES['pic']['name']) {
  $user['pic'] = upload($_FILES['pic']);
}
if (isset($user['oldPic'])) {
  $oldPic = '../../uploads/' . $user['oldPic'];
  unset($user['oldPic']);
}

$id = $user['id'];
unset($user['id']);
unset($user['repwd']);

$str = "";
foreach($user as $key => $value) {
  $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
  $value = addslashes($value);
  $str .= $key . "='" . $value . "',";
}

$str = rtrim($str, ',');
$sql = "UPDATE `user` SET {$str} WHERE id={$id}";
$res = $link->query($sql);
// 插入数据库成功
if ($res == TRUE) {
  if (($oldPic !== "") && (isset($user['pic']))) {
    if (file_exists(realpath($oldPic))) {
      unlink($oldPic);
    }
  }
  echo "<script>window.location.href='./user.php'</script>";
}
// 插入数据库失败
else {
  // 上传了头像, 但是插入数据库失败,删除新上传的头像
  if (isset($user['pic'])) {
    $pic = '../../uploads/' . $user['pic'];
    unlink($pic);
  }
  printf("修改用户信息失败! ERRNO: %d %s\n", $link->errno, $link->error);
  echo $sql;
}
$link->close();

?>
