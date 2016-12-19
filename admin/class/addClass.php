<?php
include_once '../../public/config.php';
include '../public/acl.php';
include '../../public/dbconnect.php';

if (isset($_GET['pid'])) {
  $pid = $_GET['pid'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>『有主机上线』后台管理</title>
  <link rel="stylesheet" type="text/css" href="../css/common.css"/>
  <link rel="stylesheet" type="text/css" href="../css/main.css"/>
  <script type="text/javascript" src="../js/libs/modernizr.min.js"></script>
<!--  <script type="text/javascript" src="../js/libs/jquery-3.1.0.slim.min.js"></script>-->
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
      <div class="crumb-list">
        <i class="icon-font"></i>
        <a href="../index.php">首页</a><span class="crumb-step">&gt;</span>
        <a class="crumb-name" href="./class.php">分类管理</a>
        <span class="crumb-step">&gt;</span><span>新增分类</span></div>
    </div>
    <div class="result-wrap">
      <div class="result-content">
        <form action="./do_add_class.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
          <table class="insert-tab" width="100%">
            <tbody>
            <tr>
              <th><i class="require-red">*</i>分类名：</th>
              <td>
                <input class="common-text required" id="classname" name="classname" size="50" value="" type="text" required autofocus>
              </td>
            </tr>
            <tr>
              <th><i class="require-red">*</i>上级分类：</th>
              <td>
                <select name="pid" id="">
                  <option value="0">顶级分类</option>
                  <?php
                  /* 一级分类 */
                  $sql = "SELECT `classid`,`classname` FROM `class` WHERE `pid`=0";
                  $res = $link->query($sql);
                  while (list($classid, $classname) = $res->fetch_row()) {
                    if ($classid == $pid) {
                      echo "<option selected='selected' value='{$classid}'>&nbsp;&nbsp;├ {$classname}</option>";
                    } else {
                      echo "<option value='{$classid}'>&nbsp;&nbsp;├ {$classname}</option>";
                    }
                  }
                  $res->free();
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <th>类别描述：</th>
              <td><textarea name="description" class="common-textarea" id="content" cols="30" style="width: 98%;" rows="10"></textarea></td>
            </tr>
            <tr>
              <th></th>
              <td>
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
