<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/31/16
 * Time: 7:53 PM
 */
include_once ("../../public/config.php");
include_once ("../public/acl.php");
include ("../../public/dbconnect.php");
?>
<!doctype html>
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
  <?php include("../public/topbar.php"); ?>
</div>
<div class="container clearfix">
  <?php include("../public/sidebar.php"); ?>
  <!--/sidebar-->
  <div class="main-wrap">
    <div class="crumb-wrap">
      <div class="crumb-list"><i class="icon-font"></i><a href="<?php echo $domain ?>/admin/index.php">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">文章详情</span></div>
    </div>
    <div class="article-detail">
      <article>
        <?php
        if (isset($_GET)) {
          $artid = $_GET['artid'];
          $sql = "SELECT `content` FROM `article` WHERE id={$artid}";
          $res = $link->query($sql);
          if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $content = htmlspecialchars($row['content']);
            printf("%s", $content);
          } else {
            printf("查询文章详情错误(%d): %s\nSQL: %s", $link->errno, $link->error, $sql);
          }
        }
        ?>
      </article>
      <input type="button" name="sub" onclick="javascript:history.back(-1)" value="返回上一页"/>
    </div>
  </div>
</div>
  <!--/main-->
</div>
</body>
</html>
