<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>个人中心 - 邮箱设定</title>
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
?>
<div id="content-container" class="container">
  <div class="row">
    <div class="sidenav col-md-3">
      <ul class="list-group">
        <li class="list-group-heading">个人设置</li>
        <li class="list-group-item"><a href="member.php">基础信息</a></li>
        <li class="list-group-item"><a href="avatar.php">头像设置</a></li>
        <li class="list-group-item"><a href="password.php">密码修改</a></li>
        <li class="list-group-item active"><a href="email.php">邮箱设置</a></li>
      </ul>
    </div>
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">邮箱设置</div>
      </div>
      <?php
      $id = intval($_SESSION['user']['id']);
      $sql = "select email from user where id={$id}";
      $res = $link->query($sql);
      $row = $res->fetch_row();
      $email = $row[0];
      $res->free();
      ?>
      <div class="panel-body">
        <!-- 基础信息 -->
        <form id="user-profile-form" class="form-horizontal" method="post" action="do_mod_email.php">
          <!-- 取session中用户ID传递数据库  -->
          <input type="hidden" name="id" value="<?php echo $id ?>"/>
          <div class="form-group">
            <label>邮箱</label><input class="common-text" type="email" id="" name="email"
                                    value="<?php echo $email ?>" placeholder="在这里设置邮箱" required />
            <div class="help-block" id=""></div>
          </div>
          <div class="row" style="margin-top: -20px;">
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
</html>

