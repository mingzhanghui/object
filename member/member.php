<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>个人中心 - 基础设定</title>
  <link type="text/css" rel="stylesheet" href="../css/common.css" />
  <link type="text/css" rel="stylesheet" href="../css/profile.css" />
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/23/16
 * Time: 3:21 PM
 */
session_start();

include('../public/config.php');
include('../public/header.php');
include('../public/nav.html');
include('../public/dbconnect.php');

$id = $_SESSION['user']['id'];
$sql = "select username, mobile, sex, info from user where id={$id}";
$res = $link->query($sql);
if ($res->num_rows > 0) {
  $row = $res->fetch_assoc();
//  $username = addslashes(htmlspecialchars($row['username']));
  $username = $row['username'];
  $mobile = $row['mobile'];
  $sex = $row['sex'];
//  $info = addslashes(htmlspecialchars($row['info']));
  $info = $row['info'];
} else {
  echo "0 user result";
}
$res->free_result();
?>
<div id="content-container" class="container">
  <div class="row">
    <div class="sidenav col-md-3">
      <ul class="list-group">
        <li class="list-group-heading">个人设置</li>
        <li class="list-group-item active"><a href="member.php">基础信息</a></li>
        <li class="list-group-item"><a href="avatar.php">头像设置</a></li>
        <li class="list-group-item"><a href="password.php">密码修改</a></li>
        <li class="list-group-item"><a href="email.php">邮箱设置</a></li>
      </ul>
    </div>
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">基础信息</div>
      </div>
      <div class="panel-body">
        <!-- 基础信息 -->
        <form id="user-profile-form" class="form-horizontal" method="post" action="member_update.php">
          <div class="form-group">
            <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id'] ?>"/>
            <label><i class="require-red">*</i>用户名</label><input type="text" id="" name="username" class="common-text" value="<?php echo $username ?>" required>
            <div class="help-block"></div>
          </div>
          <div class="form-group">
            <label>手机号码</label><input type="tel" id="mobile" name="mobile" class="common-text" value="<?php echo $mobile ?>">
            <div class="help-block"></div>
          </div>
          <div class="form-group">
            <label><i class="require-red">*</i>性别</label>
            <input type="radio" id="" name="sex" value="男" <?php if ($sex == '男') echo "checked" ?>/>男
            <input type="radio" id="" name="sex" value="女" <?php if ($sex == '女') echo "checked" ?>/>女
          </div>
          <div class="form-group">
            <label>个人简介</label>
            <textarea name="info"><?php echo $info ?></textarea>
          </div>
          <div class="row">
            <button id="profile-save-btn" data-submiting-text="正在保存" type="submit">保存</button>
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
<script>
  function isMobile(number) {
    // 仅限中国手机号+86
    var pat = /^(\+86)?1[358][0-9]{9}$/;
    return pat.test(number);
  }
  var mobile = document.getElementById("mobile");
  var helpBlock = document.getElementsByClassName("help-block")[1];
  mobile.onfocus = function () {
    helpBlock.innerText = '';
  }
  mobile.onblur = function () {
    if (mobile.value === '') {
      helpBlock.innerText = '手机号码为空';
    }
    else if (!isMobile(mobile.value)) {
      helpBlock.innerText = '手机号码不合法';
    }
  }
</script>
</html>

