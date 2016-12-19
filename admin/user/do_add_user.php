<?php
include('../public/function.php');
include('../../public/dbconnect.php');

if ($_POST) {
  $user = $_POST;
  if ($user['pwd'] == $user['repwd']) {
    $user['pwd'] = md5($user['pwd']);
    unset($user['repwd']);
  }
    
  if ($_FILES) {
    $user['pic'] = upload($_FILES['pic']);
  }

  $user = array_filter($user);
  $user['createTime'] = time();

  while (list($key, $value) = each($user)) {
    $value = htmlspecialchars($value);
    $value = addslashes($value);
  }
  // 每个单引号替换为２个单引号
  $user['username'] = str_replace("'", "''", $user['username']);
  $user['info'] = str_replace("'", "''", $user['info']);

  $fields = "`" . implode("`,`", array_keys($user)) . "`";
  $values = "'" . implode("','", $user) . "'";
  $sql = "INSERT INTO `user`(" . $fields . ") VALUES(" . $values . ")";

  $res = $link->query($sql);
  if ($res == TRUE) {
    echo "<script>window.location.href=\"./user.php\"</script>";
  } else {
    printf("添加用户失败(%d): %s<br />[SQL]: %s", $link->errno, $link->error, $sql);
    unlink($user['pic']);
    // echo "<script>window.location.href='./addUser.php'</script>";
  }
  $link->close();
}

?>
