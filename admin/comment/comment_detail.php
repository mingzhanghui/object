<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 11/1/16
 * Time: 11:03 AM
 */
include_once ("../../public/config.php");
include_once ("../public/acl.php");
include ("../../public/dbconnect.php");
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title>后台管理 - 文章评论详情</title>
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
      <div class="crumb-list"><i class="icon-font"></i><a href="<?php echo $domain ?>/admin/index.php">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">评论详情</span></div>
    </div>
    <div class="article-detail">
      <article>
        <?php
        if (isset($_GET)) {
          $artid = $_GET['artid'];
          $sql = "SELECT title from article where id={$artid}";
          $res = $link->query($sql);
          if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $title = htmlspecialchars($row['title']);
            printf("<header><h2>%s</h2></header>", $title);
          } else {
            printf("查询文章标题错误(%d): %s\nSQL: %s", $link->errno, $link->error, $sql);
          }
          $res->free_result();

          $sql = "SELECT comment.id, user.username as username, replyTime, replyType, replyContent, replyId from `user` inner join `comment`
           on user.id = comment.replyUserID where artid={$artid} order by replyTime desc";
          $res = $link->query($sql);
          while (list($id, $username, $replyTime, $replyType, $replyContent, $replyId) = $res->fetch_row()) {
            ?>
            <div class="comment-entry">
              <div>
                <span><?php echo $id ?>.</span><?php echo $username?>在
                <?php
                echo date('Y-m-d H:i:s', $replyTime);
                if ($replyType==1) {
                  echo "评论";
                } else {
                  echo "回复(#{$replyId})";
                }
                ?>:
              </div>
              <div><?php echo htmlspecialchars($replyContent) ?></div>
            </div>
        <?php
          }
          $res->free_result();
          $link->close();
        }
        ?>
      </article>
      <input type="button" name="sub" onclick="javascript:history.back(-1)" value="返回" tabindex="1"/>
    </div>
  </div>
</div>
<!--/main-->
</div>
</body>
</html>
