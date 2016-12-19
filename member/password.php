<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>个人中心 - 密码修改</title>
  <link type="text/css" rel="stylesheet" href="../css/common.css" />
  <link type="text/css" rel="stylesheet" href="../css/profile.css" />
  <script type="text/javascript" src="../admin/js/libs/jquery-3.1.0.slim.min.js"></script>
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
?>
<div id="content-container" class="container">
  <div class="row">
    <div class="sidenav col-md-3">
      <ul class="list-group">
        <li class="list-group-heading">个人设置</li>
        <li class="list-group-item"><a href="member.php">基础信息</a></li>
        <li class="list-group-item"><a href="avatar.php">头像设置</a></li>
        <li class="list-group-item active"><a href="password.php">密码修改</a></li>
        <li class="list-group-item"><a href="email.php">邮箱设置</a></li>
      </ul>
    </div>
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">密码修改</div>
      </div>
      <div class="panel-body">
        <form id="user-profile-form" class="form-horizontal" method="post" action="do_mod_pwd.php"
              onsubmit="if(this.pwd.value!==this.repwd.value) {$('#help-repwd').text('两次输入密码不一致'); return false;}">
          <!-- 取session中用户ID传递数据库  -->
          <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id'] ?>"/>
          <div class="form-group">
            <label>旧密码</label><input class="common-text" type="password" id="oldpwd" name="oldpwd" required />
             <div class="help-block" id="help-oldpwd"></div>
          </div>
          <div class="form-group">
            <label>新密码</label><input class="common-text" type="password" id="pwd" name="pwd" minlength="5" required/>
            <div class="help-block" id="help-pwd"></div>
          </div>
          <div class="form-group">
            <label>确认密码</label><input class="common-text" type="password" id="repwd" name="repwd" required onfocus="$(this).next().text('')"/>
            <div class="help-block" id="help-repwd"></div>
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
  $('#oldpwd').focus(function () {
    $(this).next().text('');
  });
  $('#oldpwd').blur(function () {
    if($(this).val() === '') {
      $(this).next().text('请输入原密码');
    }
  });
  $('#pwd').focus(function() {
    $(this).next().text('');
  });
  $('#pwd').blur(function() {
    if ($(this).val().length < 5) {
      $(this).next().text('密码长度至少5位');
    }
    if ($(this).val() === $('#oldpwd').val()) {
      $(this).next().text('新密码不能与旧密码相同');
    }
  });
</script>
</html>

