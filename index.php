<?php
session_start();
include ("./public/config.php");
include ("./public/dbconnect.php");

// 用于登录后跳转
$url = $protocol .$_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"]. $_SERVER["REQUEST_URI"];
setcookie('referer', $url, time() + 300);

// 获取由二级分类ID到一级分类ID的关联数组
function getParentClassId($link, $rootid=0) {
  $arrGetPid = array();
  $rootid = intval($rootid);
  $sql = "SELECT classid, pid FROM class WHERE pid != {$rootid}";
  $result = $link->query($sql);
  while (list($classid, $pid) = $result->fetch_row()) {
    $arrGetPid[$classid] = $pid;
  }
  return $arrGetPid;
}
$arrGetPid = getParentClassId($link);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="keywords" content="<?php echo keywords; ?>" />
  <meta name="description" content="<?php echo description; ?>" />
  <title>前台主页 - 热门文章</title>
  <link rel="stylesheet" type="text/css" href="./css/common.css" />
  <link rel="stylesheet" type="text/css" href="./css/article.css" />
</head>
<body class="article-cat-page" onload="">
<div class="es-wrap">
  <?php
  include "./public/header.php";
  include "./public/nav.html";
  ?>
  <div id="content-container" class="container">
    <!-- 文章分类标签   -->
    <div class="es-tabs article-list-header">
      <div class="tab-header">
        <ul class="clearfix">
          <li class="" role="presentation">
            <a href="index.php">热门文章</a>
          </li>
          <li class="active">
            <a href="index.php">技术文章</a>
          </li>
          <li class="">
            <a href="index.php">行业资讯</a>
          </li>
        </ul>
      </div>
      <div class="tab-body">
        <ul class="clearfix">
          <li class="all active"><a href="index.php?classid=0">全部</a></li>
          <?php
          /* 显示前5个技术文章分类 - 一级分类 - */
          $pid = 0;
          $sql = "select classid, classname from class where pid=? limit 5;";
          if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("i", $pid);
            $stmt->execute();
            $stmt->bind_result($classid, $classname);
            while ($stmt->fetch()) {
              $classname = htmlspecialchars($classname);
              echo "<li><a href=\"?classid={$classid}\">{$classname}</a></li>";
            }
            $stmt->close();
          }
          ?>
        </ul>
      </div>
    </div>
    <!-- 文章列表   -->
    <div class="article-list-body">
      <div class="article-list-main">
        <div class="es-section">
          <!-- 每篇文章开始 -->
          <?php
          $where = "";
          // 默认是全部分类
          if (!isset($_GET['classid'])) {
            $_GET['classid'] = 0;
          }
          // 获取这个分类的ID以及这个分类的子分类的ID
          $classid = $_GET['classid'];
          // 全部分类 0
          if ($classid == 0) {
            $where = "";
          } else {
            $arrClassId = array();
            // 加入分类ID
            array_push($arrClassId, $classid);
            // 加入子分类ID
            foreach ($arrGetPid as $id => $pid) {
              if ($pid == $classid) {
                array_push($arrClassId, $id);
              }
            }
            $str = implode(",", $arrClassId);
            $where = "where article.classid in ($str)";
          }

          $sql = "select count(id) as count from article ${where}";
          $result = $link->query($sql);
          $row = $result->fetch_assoc();
          // 数据总条数
          $total = $row['count'];
          $result->free_result();

          // 每一页显示10条数据
          $limit = 10;
          // 需要分多少页
          $pageCount = ceil($total / $limit);
          // @$page: 当前页数 GET传参数page=?指定
          $page = isset($_GET['page']) ? $_GET['page'] : 1;
          // 处理不合法的页数
          if ( ($page > $pageCount) || ($page < 1) ) {
            $page = 1;
          }
          $sqlLimit = sprintf("limit %d,%d", ($page-1) * $limit, $limit);

          $sql = "select `id`,`time`,`classname`,`title`,`content`,`pic` from `article` inner join `class` on `class`.`classid` = `article`.`classid` {$where} order by time desc {$sqlLimit}";
          $result = $link->query($sql, MYSQLI_USE_RESULT);
          if (!$result) {
            printf("sql: %s 没有返回结果集", $sql);
            exit;
          }
          while ($row = $result->fetch_row()) {
            $id = $row[0];
            $classname = $row[2];
            // printf("%s (%s) (%s) (%s)<br />", $row[0], $row[1], $row[2], $row[3]);
            $timestamp = $row[1];
            $mm = date('m', $timestamp);
            $dd = date('d', $timestamp);
            ?>
            <article class="article-item">
              <div class="article-metas">
                <div class="pull-left">
                  <div class="date">
                    <div class="day"><?php printf("%02d", $dd); ?></div>
                    <div class="month"><?php printf("%02d", $mm); ?>月</div>
                  </div>
                </div>
                <div class="metas-body">
                  <!-- 显示一级分类ID   -->
                  <p><a class="link-light" href="#"><?php echo $classname; ?></a></p>
                  <h2 class="title">
                    <!-- 文章标题  限定16个utf8字符...-->
                    <a class="link-dark" href="article.php?artid=<?php echo $id; ?>&classname=<?php echo $classname; ?>">
                      <?php
                      $title = $row[3];
                      $showTitle = mb_strlen($title, 'utf-8') > 16 ? mb_substr($title,0,16,'utf-8') . "..." : $title;
                      echo $showTitle;
                      ?>
                    </a>
                  </h2>
                </div>
              </div>
              <div class="content">
                <!-- 文章缩略图 -->
                <div class="content-left">
                  <?php
                  $img = $row[5];
                  if ($img !== "") {
                    // $path = $_SERVER['DOCUMENT_ROOT'].'/object/uploads/'.$img;
                    $path = realpath(__DIR__. "/uploads/" . $img);
                    if (file_exists($path)) {
                      echo "<img class='thumb-img' src='./uploads/{$img}' alt='{$title}'/>";
                    }
                  }
                  ?>
                </div>
                <!--文章文字内容 限定260个utf-8个字符... -->
                <div class="content-right">
                  <?php
                  // trim the ASCII control characters at the beginning of $binary
                  // (from 0 to 31 inclusive)
                  $content = ltrim($row[4], "\x00..\x1F");
                  $content = strip_tags($content);
                  if (mb_strlen($content, 'utf-8') > 260) {
                    $showContent = mb_substr($content,0,260,'utf-8') . "...";
                  } else {
                    $showContent = $content;
                  }
                  echo $showContent;
                  ?>
                </div>
              </div>
            </article>
            <?php
          }
          $result->free_result();
          ?>
          <!-- 每篇文章结束 -->
          <!--  文章翻页  -->
          <nav>
            <ul class="pager">
              <?php
              $hasPrev = ($page <= 1) ? "false" : "true";
              $hasNext = ($page >= $pageCount) ? "false" : "true";
              ?>
              <li class="previous <?php if ($hasPrev==="false") echo "disabled"; ?>"><a href="?classid=<?php $classid ?>&page=<?php printf("%d", $page - 1); ?>" onclick="return <?php echo $hasPrev ?>">< 上一页</a></li>
              <li class="first"><a href="?classid=<?php echo $classid ?>&page=1" onclick="return <?php echo $hasPrev ?>">首页</a></li>
              <li class="last"><a href="?classid=<?php echo $classid ?>&page=<?php echo "{$pageCount}"; ?>" onclick="return <?php echo $hasNext ?>">尾页</a></li>
              <li class="next <?php if ($hasNext==="false") echo "disabled"; ?>"><a href="?classid=<?php echo $classid ?>&page=<?php printf("%d", $page + 1); ?>" onclick="return <?php echo $hasNext ?>">下一页 ></a></li>
            </ul>
          </nav>
        </div>
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
<script type="text/javascript" src="./js/loading.js"></script>
<script type="text/javascript" src="./js/dropdown.js"></script>
</body>
</html>
<?php
unset($arrGetPid);
$link->close();
?>
