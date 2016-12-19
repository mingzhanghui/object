<?php
include_once ("../../public/config.php");
include ("../public/acl.php");
include '../../public/dbconnect.php';
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
      <div class="crumb-list"><i class="icon-font"></i><a href="<?php echo $domain ?>/admin/index.php">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">评论管理</span></div>
    </div>
    <div class="result-wrap">
      <!--  搜索开始  -->
      <div class="search-tab">
        <form action="comment.php" method="get">
          <table class="search-tab">
            <tbody>
            <tr>
              <th width="80">文章标题: </th>
              <td><input class="common-text" placeholder="标题关键字" name="keywords" type="text" tabindex="1"/></td>
              <td><input class="btn btn-primary btn2" name="submit" value="查询" type="submit" tabindex="2" /></td>
            </tr>
            </tbody>
          </table>
        </form>
      </div>
      <!-- 搜索结束-->
      <form name="myform" id="myform" method="post">
        <div class="result-title">
          <div class="result-list">
            <a href="replyComment.php"><i class="icon-font"></i>回复评论</a>
            <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
            <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
          </div>
        </div>
        <div class="result-content">
          <table class="result-tab comment-table" width="100%">
            <tr>
              <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
              <th>ID</th>
              <th>文章ID</th>
              <th width="">文章标题</th>
              <th width="">回复时间</th>
              <th>评论人</th>
              <th width="">评论内容</th>
              <th>回复ID</th>
              <th>操作</th>
            </tr>
            <?php

            $where = "";
            if (isset($_GET)) {
              if (isset($_GET['keywords'])) {
                $keyword = $_GET['keywords'];
                $where = $keyword ? "where title like '%{$keyword}%'" : "";
              }
            }
            $sql = "select comment.id as id, article.id as artid, article.title as title, comment.replyTime as `time`, 
            user.username as username, comment.replyContent as content, comment.replyid as replyid
            from `comment`  inner join `user` on comment.replyUserID = `user`.id
            inner join `article` on comment.artid = article.id {$where} order by `time` desc";
            $res = $link->query($sql);
            $i = 0;
            while (list($id, $artid, $title, $time, $username, $content, $replyid) = $res->fetch_row()) {
            ?>
            <tr>
              <td class="tc"><input name="id[]" value="<?php echo $i; ?>" type="checkbox"></td>
              <td>
                <input name="ids[]" value="<?php echo $i++; ?>" type="hidden">
                <input class="common-input sort-input" name="" value="<?php echo $id ?>" type="text">
              </td>
              <td title="文章ID"><?php echo $artid ?></td>
              <td width="" class="td-title" title="文章标题"><a target="" href="../comment/comment_detail.php?artid=<?php echo $artid ?>" title="<?php echo $title ?>"><?php echo $title ?></a></td>
              <td width="" title="回复时间"><?php echo date('Y-m-d H:i:s', $time) ?></td>
              <td><?php echo $username ?></td>
<!--              <td>--><?php //$content = htmlspecialchars($content); if (strlen($content) > 40) {$content = substr($content, 0, 40);} echo $content; ?><!--</td>-->
              <td width="" title="<?php echo $content = htmlspecialchars($content); ?>">
                <?php echo $content; ?>
              </td>
              <td><?php echo ($replyid == 0) ? '-' : $replyid ?></td>
              <td>
                <a class="link-del" href="replyComment.php?artid=<?php echo $artid ?>&replyId=<?php echo $id ?>">回复</a>
                <a class="link-del" href="del_comment.php?id=<?php echo $id ?>">删除</a>
              </td>
            </tr>
            <?php
            }
            ?>
          </table>
          <div class="list-page"> <?php echo $i ?> 条 1/1 页</div>
        </div>
      </form>
    </div>
  </div>
  <!--/main-->
</div>
</body>
</html>
