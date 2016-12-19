<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/23/16
 * Time: 3:15 PM
 */
include_once '../../public/config.php';
include '../public/acl.php';
include '../../public/dbconnect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>后台管理</title>
  <link rel="stylesheet" type="text/css" href="../css/common.css"/>
  <link rel="stylesheet" type="text/css" href="../css/main.css"/>
  <script type="text/javascript" src="../js/libs/modernizr.min.js"></script>
</head>
<body>
<div class="topbar-wrap white">
  <?php include "../public/topbar.php"?>
</div>
<div class="container clearfix">
  <?php include "../public/sidebar.php" ?>
  <!--/sidebar-->
  <div class="main-wrap">
    <div class="crumb-wrap">
      <div class="crumb-list"><i class="icon-font"></i><a href="../index.php">首页</a><span class="crumb-step">&gt;</span>
        <a class="crumb-name" href="link.php">友情链接管理</a><span class="crumb-step">&gt;</span><span>新增链接</span>
      </div>
    </div>
    <div class="result-wrap">
      <div class="result-content">
        <form action="do_add_link.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
          <table class="insert-tab" width="100%">
            <tbody>
            <tr>
              <th width="120"><i class="require-red">*</i>分类：</th>
              <td>
                <select name="type" id="catid" class="required">
                  <option value="">请选择</option>
                  <option value="LOGO链接">LOGO链接</option><option value="文字链接">文字链接</option>
                </select>
              </td>
            </tr>
            <tr>
              <th><i class="require-red">*</i>网站名称：</th>
              <td>
                <input class="common-text required" id="title" name="sitename" size="50" value="" type="text" required />
              </td>
            </tr>
            <tr>
              <th><i class="require-red">*</i>网站URL：</th>
              <td>
                <input class="common-text required" type="url" id="siteurl" name="siteurl" size="50" value="" type="text" required />
              </td>
            </tr>
            <tr>
              <th>联系人：</th>
              <td><input class="common-text" name="contact" size="50" value="" type="text"></td>
            </tr>
            <tr>
              <th>缩略图：</th>
              <td><input name="pic" id="" type="file"></td>
            </tr>
            <tr>
              <th>介绍：</th>
              <td><textarea class="common-textarea" name="introduce" id="content" cols="30" style="width: 98%;" rows="10"></textarea></td>
            </tr>
            <tr>
              <th>是否推荐：</th>
              <td>
                <input class="common-text" name="recommend" type="radio" checked value="1">否
                <input class="common-text" name="recommend" type="radio" value="2">是
              </td>
            </tr>
            <tr>
              <th>审核状态：</th>
              <td>
                <input class="common-text" name="pass" type="radio" checked value="1">未通过
                <input class="common-text" name="pass" type="radio" value="2">通过
              </td>
            </tr>
            <tr>
              <th></th>
              <td>
                <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                <input class="btn btn6" onclick="history.go(-1)" value="返回" type="button">
              </td>
            </tr>
            </tbody></table>
        </form>
      </div>
    </div>

  </div>
  <!--/main-->
</div>
</body>
</html>
