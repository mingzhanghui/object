<?php
include '../public/acl.php';

if ($_POST) {
  include '../../public/dbconnect.php';

  if (isset($_POST['classname'])) {
//    变量名称缩短
    $classname = $_POST['classname'];

//    处理特殊字符串
    $classname = urlencode($classname);
    $classname = $link->real_escape_string(htmlspecialchars($classname));
//　空字符串排除
    if (($classname = trim($classname, " \t")) === "" ) {
      die("classname不能为空字符串");
    }
  }

  $pid = intval($_POST['pid']);
  $desc = trim($_POST['description']);
  $desc = $link->real_escape_string(htmlspecialchars($desc));

  /* 检查分类名是否已经存在 */
  $sql = "SELECT `classid` FROM `class` WHERE `classname` = '{$classname}'";
  $res = $link->query($sql);
  $row = $res->fetch_array(MYSQLI_ASSOC);
  if ($row) {
    printf("分类名称已存在！");
    exit;
  }

  $sql = sprintf("INSERT INTO `class`(`classname`,`pid`,`description`) VALUES('%s','%d','%s')",
    $classname, $pid, $desc);
  $res = $link->query($sql);
  $link->close();

  if ($res === TRUE) {
    // header("Location: ", $_SERVER['HTTP_REFERER']);
    echo "<script>window.location.href='./class.php?search-sort={$pid}'</script>";
  } else {
    echo "<script>window.location.href='./addClass.php'</script>";
  }
}
?>
