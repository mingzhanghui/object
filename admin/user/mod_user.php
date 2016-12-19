<?php
include ("../public/acl.php");
include ('../../public/dbconnect.php');
$id = $_GET['id'];
$sql = "SELECT `id`,`username`,`pic`,`email`,`sex`,`status`,`isAdmin`,`info` FROM `user` WHERE id={$id}";
$res = $link->query($sql);
$user = $res->fetch_assoc();
// 简短变量名, htmlspecialchars_decode, stripslashes
$username = $user['username'];
$info = $user['info'];
?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title>『有主机上线』后台管理</title>
  <link rel="stylesheet" type="text/css" href="../css/common.css"/>
  <link rel="stylesheet" type="text/css" href="../css/main.css"/>
  <script type="text/javascript" src="../js/libs/modernizr.min.js"></script>
</head>
<body>
<div class="topbar-wrap white">
  <?php
  include("../public/topbar.php");
  ?>
</div>
<div class="container clearfix">
  <?php
  include("../public/sidebar.php");
  ?>
  <!--/sidebar-->
  <div class="main-wrap">

    <div class="crumb-wrap">
      <div class="crumb-list"><i class="icon-font"></i><a href="../index.php">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="./user.php">用户管理</a><span class="crumb-step">&gt;</span><span>修改用户</span></div>
    </div>
    <div class="result-wrap">
      <div class="result-content">
        <form action="./do_mod_user.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
          <table class="insert-tab" width="100%">
            <tbody>
            <tr>
              <th><i class="require-red">*</i>用户名：</th>
              <td>
                <input class="common-text required" id="username" name="username" size="50"
                       value="<?php
                              // echo $username = htmlspecialchars_decode($username);
                              // echo $username = addslashes($username);
                       echo $username;
                              ?>"
                 type="text" required autofocus>
              </td>
            </tr>
            <tr>
              <th>密码：</th>
              <td>
                <input class="common-text required" id="pwd" name="pwd" size="50" type="password">
              </td>
            </tr>
            <tr>
              <th></i>确认密码：</th>
              <td>
                <input class="common-text required" id="repwd" name="repwd" size="50" type="password" >
              </td>
            </tr>
            <tr>
              <th>邮箱：</th>
              <td><input class="common-text" name="email" size="50"  type="text" value="<?php echo $user['email'] ?>"></td>
            </tr>
            <tr>
              <th>性别：</th>
              <td>
                <input class="common-text" name="sex" type="radio" <?php echo $user['sex'] == '男' ? "checked" : "" ?> value="男">男
                <input class="common-text" name="sex" type="radio" <?php echo $user['sex'] == '女' ? "checked" : "" ?> value="女">女
              </td>
            </tr>
            <tr>
              <th>状态：</th>
              <td>
                <input class="common-text" name="status" type="radio" <?php echo $user['status'] == 1 ? "checked" : "" ?> value="1">开启
                <input class="common-text" name="status" type="radio" <?php echo $user['status'] == 2 ? "checked" : "" ?> value="2">禁用
              </td>
            </tr>
            <tr>
              <th>设置管理员</th>
              <td>
                <input class="common-text" type="radio" name="isAdmin" <?php  $user['isAdmin'] == 1 ? "checked" : "" ?> value="1" />否
                <input class="common-text" type="radio" name="isAdmin" <?php $user['isAdmin'] == 2 ? "checked" : ""  ?> value="2" />是
              </td>
            </tr>
            <tr>
              <th>头像：</th>
              <td>
                <input name="pic" id="" type="file" accept='image/*' >
                <img src="../../uploads/<?php echo $user['pic'] ?>" width="35"/>
                <input type="hidden" name="oldPic" value="<?php echo $user['pic'] ?>">
                <!--<input type="submit" onclick="submitForm('/jscss/admin/design/upload')" value="上传图片"/>-->
              </td>
            </tr>
            <tr>
              <th>简介：</th>
              <td><textarea name="info" class="common-textarea" id="content" cols="30" rows="10"><?php $info = htmlspecialchars_decode($info); echo $info = stripcslashes($info); ?></textarea></td>
            </tr>
            <tr>
              <th></th>
              <td>
                <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
                <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                <input class="btn btn6" onclick="history.go(-1)" value="返回" type="button">
              </td>
            </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>

  </div>
  <!--/main-->
</div>
</body>
</html>
<?php
$res->free();
$link->close();
?>
