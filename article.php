<?php
include_once ('./public/config.php');
include_once('./public/dbconnect.php');
include('./public/function.php');

$url = $protocol .$_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"]. $_SERVER["REQUEST_URI"];
setcookie('referer', $url, time() + 300);

session_start();

// 通过用户ID找到用户的用户名和头像, 生成数组$replyUser
$replyUser = array();
$sql = "select id,username,pic from user";
$res = $link->query($sql);
while (list($replyUserId, $replyUserName, $pic) = $res->fetch_row() ) {
  array_push($replyUser, array($replyUserId, $replyUserName, $pic));
}
unset($res);

// 通过文章ID查询出文章详情
$classname = '全部';
$artid = '0';
if (isset($_GET)) {
  if (isset($_GET['classname'])) {
    $classname = $_GET['classname'];
  }
  if (isset($_GET['artid'])) {
    $artid = $_GET['artid'];
  }
}
$artid = intval($artid);
$sql = "select `title`,`time`,`pic`,`content`,`views`,`hot` from `article` where `id`={$artid}";
$res = $link->query($sql);
list($title, $time, $pic, $content, $views, $hot) = $res->fetch_row();
if ($res->num_rows < 1) {
  printf("找不到这个文章: %s<br />[SQL]: %s", $link->error, $sql);
  exit;
}
$mm = date('m', $time);   // 月份
$dd = date('d', $time);   // 日期

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title><?php echo $title ?></title>
  <link rel="stylesheet" href="./css/common.css" />
  <link rel="stylesheet" href="./css/article.css" />
<!--  <link rel="stylesheet" href="./css/turing.css" />-->
</head>
<body class="article-cat-page" onload="">
<div class="es-wrap">
  <?php
  include "./public/header.php";   // $objectRoot从这里引入
  include "./public/nav.html";
  ?>
  <div id="content-container" class="container">
    <div class="article-detail">
      <div class="article-detail-main col-md-8">
        <section class="es-section article-content">
          <ol class="breadcrumb">
            <li><a href="index.php">热门文章</a></li>
            <li><a href="#" style="font-size: 18px;">/</a></li>
            <li><a href="index.php">技术文章</a></li>
            <li><a href="#" style="font-size: 18px;">/</a></li>
            <li><a href="index.php" onclick="javascript:history.back()"><?php echo $classname; ?></a></li>
            <li><a href="#" style="font-size: 18px;">/</a></li>
            <li><a href="#">正文</a></li>
          </ol>
          <div class="article-metas">
            <div class="pull-left">
              <div class="date">
                <div class="day"><?php printf("%02d", $dd); ?></div>
                <div class="month"><?php printf("%02d", $mm); ?>月</div>
              </div>
            </div>
            <div class="metas-body">
              <h2 class="title"><?php echo $title; ?></h2>
              <div class="sns">
                <img src="./imgs/view.svg">
                <span class="num"><i class="es-icon"><?php echo $views; ?></i></span>
                <img src="./imgs/comment.svg">
                <span class="num"><i class="es-icon"><?php echo $hot; ?></i></span>
                <img src="./imgs/favourite.svg">
                <span class="num"><i class="es-icon">1</i></span>
                </ul>
              </div>
            </div>
          </div>
          <article class="article-text">
            <div>
              <?php
              // htmlspecialchars_decode, stripslashes
              $content = htmlspecialchars($content);
              $content = addslashes($content);
              printf("%s", $content);
              ?>
            </div>
            <div class="article-img">
              <?php
              if ($pic !== '') {
                echo "<img src='./uploads/{$pic}' />";
              }
              ?>
            </div>
          </article>
        </section>
        <?php
        // 用户是否登录
        $isLogin = isset($_SESSION['user']);
        ?>
        <!--　发表评论  -->
        <form class="es-comment" id="thread-post-form" method="POST" action="./do_add_comment.php">
          <div class="es-comment-header">文章评论</div>
          <?php
          if ($isLogin) {
            echo "<textarea class=\"form-control form-control-o\" rows=\"6\" placeholder=\"你的想法\" name=\"replyContent\"></textarea>";
          } else {
            echo "<textarea class=\"form-control form-control-o\" rows=\"6\" placeholder=\"还没有登录,不能发表评论\" name=\"replyContent\" disabled></textarea>";
          }
          ?>
          <div class="form-group clearfix">
            <?php if (!$isLogin) echo "<a href=\"./member/login.php\"><font color='#268eee'>登录</font></a>后发表看法"; ?>
            <button type="submit" class="btn btn-default pull-right" data-loading-text="正在评论" <?php echo $isLogin ?  '': 'disabled' ?>>发表评论</button>
          </div>
          <input type="hidden" name="artid" value="<?php echo $artid; ?>">
          <input type="hidden" name="replyUserID" value="<?php echo $_SESSION["user"]["id"]; ?>">
          <!--  @replyType: 1 - 评论, 2 - 回复 -->
          <input type="hidden" name="replyType" value="1">
          <input type="hidden" name="classname" value="<?php echo $classname; ?>">
        </form>

        <a name="comment_top"></a>

        <!-- 已有评论列表 -->
        <ul class="comment-list thread-pripost-list">
          <?php
          $sql = "select * from comment where artid={$artid} order by id desc;";
          $result = $link->query($sql);
          $hot = 0;  // 评论数初始化
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              // 评论ID
              $id = $row['id'];
              // 发表评论用户ID
              $replyUserId = $row['replyUserID'];
              $replyUserName = getUserNameById($replyUser, $replyUserId);
              // 发表评论用户的头像文件名 ./uploads/xxx
              $replyUserPic = getUserPicById($replyUser, $replyUserId);
              // 回复时间间隔字符串
              $replyTimeInt = getReplyTimeInt($row['replyTime']);
              // 评论具体内容
              $replyContent = htmlspecialchars($row['replyContent']);
              ?>
          <li class="thread-post media media-comment">
            <div class="media-left">
              <a class="user-avatar js-user-card" href="./member/member.php?id=<?php echo $replyUserId; ?>">
                <img class="avatar-sm" src="<?php echo $replyUserPic; ?>" alt="avatar of user id: <?php echo $replyUserId ?>"/>
              </a>
            </div>
            <div class="media-body">
              <div class="metas title">
                <a href="./member/member.php" class="nickname"><?php echo $replyUserName ?></a>
                <span class="bullet">•</span>
                <span class="text-muted"><?php echo $replyTimeInt; ?></span>
              </div>
              <div class="editor-text"><?php echo $replyContent; ?></div>
              <div class="comment-sns">
                <!--  当前登录的用户只能删除自己的评论 -->
                <?php
                if ($isLogin) {
                  if (($_SESSION['user']['id']) === $replyUserId) {
                    echo "<a href=\"del_comment.php?id={$id}&artid={$artid}&classname={$classname}\">删除</a>";
                  }
                  echo "<a href=\"javascript:;\" class=\"js-reply interaction text-muted\">回复</a>";
                }
                ?>

              </div>
              <!-- +/- class hide toggle  -->
              <div class="thread-subpost-container subcomments clearfix hide">
                <!-- 历史回复 -->
                <div class="thread-subpost-content">
                  <ul class="media-list thread-post-list thread-subpost-list"></ul>
                  <div class="text-center"></div>
                </div>
                <!-- 回复数 > 5, 折叠回复 -->
                <div class="thread-subpost-morebar clearfix hide">
                  <button class="btn btn-default btn-xs pull-right js-toggle-subpost-form">我也说一句</button>
                  <span class="thread-subpost-moretext">
                    <span class="text-muted">还有-5条回复</span>
                    <a href="javascript:;" class="js-post-more">点击查看</a>
                  </span>
                </div>
                <!-- 新回复表单 -->
                <!--  TODO: 回复内容在对应的评论下面展示  -->
                <form method="post" action="do_reply.php" class="thread-subpost-form"
                onsubmit = "if(this.replyContent.value=='') {alert('请输入回复内容'); return false;}">
                  <div class="form-group">
                    <div class="controls">
                      <textarea class="form-control" name="replyContent" data-display="内容" data-explain></textarea>
                    </div>
                    <input type="hidden" name="artid" value="<?php echo $artid ?>" />
                    <!-- replyUserID: 回复人ID -->
                    <input type="hidden" name="replyUserID" value="<?php echo $_SESSION['user']['id']?>" />
                    <!-- @2: 回复 @1: 评论 -->
                    <input type="hidden" name="replyType" value="2" />
                    <!-- @$id： 被回复的评论ID -->
                    <input type="hidden" name="replyId" value="<?php echo $id ?>" />
                    <button type="submit" data-loading-text="正在发表" class="btn btn-primary btn-sm pull-right">发表</button>
                  </div>
                </form>
              </div>
            </div>
          </li>
              <?php
              // 评论数目
              $hot += 1;
            } // while ($row = $result->fetch_assoc()) {
          } // if ($result->num_rows > 0) {
          else {
            echo "<li class='empty'>还没有人评论，欢迎说说您的想法！</li>";
          }
          ?>
        </ul>
  <!--          <nav class="text-center"></nav>-->
        <!-- 回复评论 -->
      </div>
      <aside class="article-sidebar">
        <?php
        // 热门资讯
        include('./public/hotart.php');
        // 热门标签
        include('./public/hottag.php');
        //热门评论
        include('./public/hotcomment.php');
        // 推荐资讯
        include('./public/hotrecmd.php');
        ?>
      </aside>
    </div>
  </div>
  <!--  footer-->
  <?php include "./public/footer.php" ?>
</div>
<!--js for nav -->
<script type="text/javascript" src="./js/dropdown.js"></script>
<script type="text/javascript" src="./js/loading.js"></script>
<script type="text/javascript" src="./js/article.js"></script>
</body>
</html>

<?php
// 浏览量 +1
$views += 1;
$sql = "update `article` set `views`={$views}, `hot`={$hot} where `id`=?";
if ($stmt = $link->prepare($sql)) {
  $stmt->bind_param("i", $artid);
  $stmt->execute();
  $stmt->close();
}

?>