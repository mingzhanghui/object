<?php
include_once "../../public/config.php";
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
    <script type="text/javascript" src="../js/libs/jquery-3.1.0.slim.min.js"></script>
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
        <div class="crumb-list"><i class="icon-font"></i><a href="../index.php">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="./article.php">博文管理</a><span class="crumb-step">&gt;</span><span>新增博文</span></div>
      </div>
      <div class="result-wrap">
        <div class="result-content">
          <form action="./do_add_article.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
            <table class="insert-tab" width="100%">
              <tbody>
                <tr>
                  <th><i class="require-red">*</i>分类：</th>
                  <td>
                    <!-- 分类下拉菜单开始 -->
                    <select id="classname" name="classid">
                      <option value="">请选择</option>
                      <?php
                      include_once '../../public/dbconnect.php';
                      $sql = "SELECT `classid`,`classname` FROM `class` WHERE `pid` = 0";
                      $res = $link->query($sql);

                      while (list($classid, $classname, $pid) = $res->fetch_row()) {
                        /* 一级分类 */
                        if ($_GET['classid'] == $classid) {
                          echo "<option selected='selected' value='{$classid}'>".$classname."</option>";
                        } else {
                          echo "<option value='{$classid}'>".$classname."</option>";
                        }
                        /* 查询二级分类 */
                        $sql = "SELECT `classid`,`classname` FROM `class` WHERE `pid`='{$classid}'";
                        $childRes = $link->query($sql);
                        while (list($classid, $classname) = $childRes->fetch_row()) {
                          if ($_GET['classid'] == $classid) {
                            echo "<option selected='selected' value='{$classid}'>&nbsp;&nbsp;├ ".$classname."</option>";
                          } else {
                            echo "<option value='{$classid}'>&nbsp;&nbsp;├ ".$classname."</option>";
                          }
                        }
                        $childRes->free();
                      }
                      $res->free();
                      ?>
                    </select>
                    <!-- 分类下拉菜单结束 -->
                  </td>
                </tr>
                <tr>
                  <th><i class="require-red">*</i>标题：</th>
                  <td><input class="common-text required" id="title" name="title" size="50" value="" type="text" required autofocus></td>
                </tr>
                <tr>
                  <th>作者：</th>
                  <td>
                    <input class="common-text required" id="author" name="author" size="50" value="" type="text" required autocomplete="off" list="authorlist" />
                    <!-- 作者名字自动补全 -->
                    <datalist id="authorlist">
                      <?php
                      $sql = "SELECT DISTINCT `username` FROM `user`";
                      $res = $link->query($sql);
                      if ($res->num_rows > 0) {
                        // output data of each row
                        while ($row = $res->fetch_assoc()) {
                          echo "<option value=\"{$row['username']}\">{$row['username']}</option>";
                        }
                      }
                      $res->free_result();
                      ?>
                    </datalist>
                  </td>
                </tr>
                <tr>
                  <th>设置推荐：</th>
                  <td>
                    <input class="common-text" type="radio" name="recommend" value="1">否
                    <input class="common-text" type="radio" name="recommend" value="2">是
                  </td>
                </tr>
                <tr>
                  <th><i class="require-red">*</i>缩略图： </th>
                  <td><input name="pic" id="" type="file" accept='image/*' ></td>
                </tr>
                <tr>
                  <th><i class="require-red">*</i>内容：</th>
                  <td>
                    <textarea id="content" name="content" class="common-textarea" cols="30" rows="16" placeholder="在这里编辑文章内容"></textarea>
                  </td>
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
