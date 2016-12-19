<?php
include_once "../../public/config.php";
include '../public/acl.php';
include '../../public/dbconnect.php';

$id = $_GET['id'];
/* 查询修改文章页面显示信息 */
$sql = "SELECT * FROM `article` WHERE `id`={$id}";
$res = $link->query($sql);
$article = $res->fetch_assoc();
$res->free();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
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
      <div class="crumb-list"><i class="icon-font"></i><a href="../index.php">首页</a>
        <span class="crumb-step">&gt;</span>
        <a class="crumb-name" href="./article.php">博文管理</a>
        <span class="crumb-step">&gt;</span><span>修改博文</span>
      </div>
    </div>
    <div class="result-wrap">
      <div class="result-content">
        <form action="./do_mod_article.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
          <table class="insert-tab" width="100%">
            <tbody>
            <!-- 分类下拉菜单 begin-->
            <tr>
              <th><i class="require-red">*</i>分类：</th>
              <td>
                <select id="classname" name="classid">
                  <option value="">请选择</option>
                  <?php
                  $sql = "SELECT `classid`,`classname` FROM `class` WHERE `pid` = 0";
                  $res = $link->query($sql);

                  while (list($classid, $classname, $pid) = $res->fetch_row()) {
                    $classname = htmlspecialchars($classname);
                    /* 一级分类 */
                    if ($article['classid'] == $classid) {
                      echo "<option selected='selected' value='{$classid}'>".$classname."</option>";
                    } else {
                      echo "<option value='{$classid}'>".$classname."</option>";
                    }
                    /* 查询二级分类 */
                    $sql = "SELECT `classid`,`classname` FROM `class` WHERE `pid`='{$classid}'";
                    $childRes = $link->query($sql);
                    while (list($classid, $classname) = $childRes->fetch_row()) {
                      $classname = htmlspecialchars($classname);
                      if ($article['classid'] == $classid) {
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
              </td>
            </tr>
            <!-- 分类下拉菜单 end-->
            <tr>
              <th><i class="require-red">*</i>标题：</th>
              <td>
                <input class="common-text required" id="title" name="title" size="50"
                       value="<?php echo $article['title']; ?>" type="text" required autofocus>
              </td>
            </tr>
            <tr>
              <th>作者：</th>
              <td><input class="common-text" id="author" name="author" size="50" value="<?php echo $article['author'] ?>" type="text"></td>
            </tr>
            <tr>
              <th>浏览次数：</th>
              <td><input class="common-text" id="" name="views" size="50" value="<?php echo $article['views'] ?>" type="number"></td>
            </tr>
            <tr>
              <th>热度：</th>
              <td><input class="common-text" id="" name="hot" size="50" value="<?php echo $article['hot'] ?>" type="number"></td>
            </tr>
            <tr>
              <th>设置推荐：</th>
              <td>
                <input class="common-text" type="radio" name="recommend" value="1">否
                <input class="common-text" type="radio" name="recommend" value="2">是
              </td>
            </tr>
            <tr>
              <th><i class="require-red">*</i>缩略图：</th>
              <td>
                <input name="pic" id="" type="file" accept='image/*' >
                <img src="../../uploads/<?php echo $article['pic'] ?>" width="35"/>
                <input type="hidden" name="oldPic" value="<?php echo $article['pic']; ?>">
              </td>
            </tr>
            <tr>
              <th><i class="require-red">*</i>内容：</th>
              <td><textarea id="content" name="content" class="common-textarea" cols="30" rows="16"><?php echo $article['content']; ?></textarea></td>
            </tr>
            <tr>
              <th></th>
              <td>
                <!-- 隐藏域用于提交ID -->
                <input type="hidden" name="id" value="<?php echo $id ?>" />
                <!-- page=4&classid=0-->
                <input type="hidden" name="page" value="<?php if(isset($_GET) && isset($_GET['page'])) {echo $_GET['page'];} ?> /"
<!--                <input type="hidden" name="classid" value="--><?php //if(isset($_GET) && isset($_GET['classid'])) {echo $_GET['classid'];} ?><!-- /"-->
                <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                <input class="btn btn6" onclick="history.back()" value="返回" type="button">
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
$link->close();
?>
