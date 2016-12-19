<?php
include_once '../../public/config.php';
include '../public/acl.php';
include '../../public/dbconnect.php';

// 评论ID
$sql = "select id from comment where replyType=1";  // 1-评论 2-回复
$result = $link->query($sql);
$arrcommentid = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    array_push($arrcommentid, $row['id']);
  }
} else {
  echo "0 comment ID result";
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>后台管理 - 回复评论</title>
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
      <div class="crumb-list"><i class="icon-font"></i><a href="../index.php">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="comment.php">评论管理</a><span class="crumb-step">&gt;</span><span>回复评论</span></div>
    </div>
    <div class="result-wrap">
      <div class="result-content">
        <form action="doReply.php" method="post" id="myform" name="addComment" enctype="multipart/form-data">
          <table class="insert-tab" width="100%">
            <tbody>
            <!-- 对这个评论ID进行回复  -->
            <tr>
              <th><i class="require-red">*</i>评论ID</th>
              <td>
                <?php
                if (isset($_GET) && isset($_GET['replyId'])) {
                  $replyId = $_GET['replyId'];
                }
                ?>
                <input class="common-text required" id="commentid" name="id" size="50" value="<?php if(isset($replyId)) echo $replyId; ?>" type="number" autocomplete="on" list="cidlist" required>
                <datalist id="cidlist">
                  <?php
                  // 评论ID
                  for ($i = 0; $i < count($arrcommentid); $i++) {
                    echo "<option class='commentids' value='{$arrcommentid[$i]}'>{$arrcommentid[$i]}</option>";
                  }
                  ?>
                </datalist>
                <div class="help-block"><!--不是有效的评论ID--></div>
              </td>
            </tr>
            <tr>
              <th>回复内容：</th>
              <td><textarea name="replyContent" class="common-textarea" id="content" cols="30" style="width: 98%;" rows="10" required></textarea></td>
            </tr>
            <tr>
              <th></th>
              <td>
                <!--  文章ID -->
                <input id="param" name="artid" type="hidden" value="" />
                <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                <input class="btn btn6" onclick="history.go(-1)" value="返回" type="button">
              </td>
            </tr>
            </tbody></table>
        </form>
      </div>
    </div>
    <?php
    unset($article);
    ?>
  </div>
  <!--/main-->
</div>
</body>
<script type="text/javascript" src="../js/checkComment.js"></script>
<script type="text/javascript" src="../js/getParam.js"></script>
</html>
