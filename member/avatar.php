<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>个人中心 - 头像设定</title>
  <link type="text/css" rel="stylesheet" href="../css/common.css" />
  <link type="text/css" rel="stylesheet" href="../css/profile.css" />
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/24/16
 * Time: 3:49 PM
 */
session_start();
include('../public/header.php');
include('../public/nav.html');
include('../public/dbconnect.php');

// 当前登录的用户ID
$id = $_SESSION['user']['id'];
$sql = sprintf("select pic from user where id=%d", intval($id));
$res = $link->query($sql);
$row = $res->fetch_array(MYSQLI_ASSOC);
if (TRUE == $res) {
  $oldpic = $row['pic'];
  $relpath = "../uploads/" . $oldpic;
} else {
  printf("查询用户头像失败(%d): %s<br />[SQL]: %s",
    $link->errno, $link->error, $sql);
  exit;
}
$abspath = realpath($relpath);
if (!file_exists($abspath)) {
  $relpath = "../imgs/avatar.png";
}
?>
<div id="content-container" class="container">
  <div class="row">
    <div class="sidenav col-md-3">
      <ul class="list-group">
        <li class="list-group-heading">个人设置</li>
        <li class="list-group-item"><a href="member.php">基础信息</a></li>
        <li class="list-group-item active"><a href="avatar.php">头像设置</a></li>
        <li class="list-group-item"><a href="password.php">密码修改</a></li>
        <li class="list-group-item"><a href="email.php">邮箱设置</a></li>
      </ul>
    </div>
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">头像</div>
      </div>
      <div class="panel-body">
        <!-- 上传头像 -->
        <form id="settings-avatar-form" class="form-horizontal" method="post" action="do_avatar_change.php" enctype="multipart/form-data">
<!--              onchange="this.submit()"-->
          <div class="form-group">
            <h3><b>当前头像: </b></h3>
            <img src="<?php echo $relpath ?>" />
          </div>
          <div class="form-group-side">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <p class="help-block">你可以上传JPG, GIF, 或PNG格式的文件大小不能超过<strong>10M</strong></p>
            <input type="file" name="avatar" id="" tabindex="3">点击这里上传文件
            <input type="hidden" name="oldPic" value="<?php echo $oldpic ?>">
            <br />
            <p>上传新头像</p>
            <input id="" data-submiting-text="正在保存" type="submit" value="保存头像" tabindex="4"/>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
include('../public/footer.php');
?>
</body>
<!--js for nav -->
<script type="text/javascript" src="../js/loading.js"></script>
<script type="text/javascript" src="../js/dropdown.js"></script>
</html>

