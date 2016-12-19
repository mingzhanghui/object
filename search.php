<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/26/16
 * Time: 3:42 PM
 */
include ("./public/dbconnect.php");
include_once ("./public/config.php");

$url = $protocol .$_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"]. $_SERVER["REQUEST_URI"];
setcookie('referer', $url, time() + 300);

session_start();
// 文章搜索页面
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="keywords" content="<?php echo keywords; ?>" />
  <meta name="description" content="<?php echo description; ?>" />
  <title>搜索: <?php  if (isset($_GET) && $_GET['q'] !== "") echo $_GET['q']; ?></title>
  <link rel="stylesheet" type="text/css" href="./css/common.css" />
  <link rel="stylesheet" type="text/css" href="./css/article.css" />
</head>
<body class="article-cat-page" onload="">
<div class="es-wrap">
  <?php
  include "./public/header.php";    // include 'config.php';
  include "./public/nav.html";
  ?>
  <div id="content-container" class="container">
    <!-- 文章列表   -->
    <div class="article-list-body">
      <div class="article-list-main">
        <div class="es-section">
          <!-- 每篇文章开始 -->
          <?php
          // @$qword 搜索关键词
          $qword = (isset($_GET) && $_GET['q'] !== "") ? $_GET['q'] : "";

          // 查找文章标题和文章内容
          $where = sprintf("where title like '%%%s%%' or content like '%%%s%%'", $qword, $qword);
          $sql = "select count(id) as count from article ${where}";
          $result = $link->query($sql);
          $row = $result->fetch_assoc();
          // 数据总条数
          $total = $row['count'];
          echo "<p>为您找到资讯结果约<span style='color:#e83d2c'>{$total}</span>个</p>";
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
          
          $sql = "select `time`,`classname`,`title`,`content`,`pic`,`id`,`class`.`classid` as `classid` from `article` inner join `class` on `class`.`classid` = `article`.`classid` {$where} {$sqlLimit}";
          $result = $link->query($sql, MYSQLI_USE_RESULT);
          if (!$result) {
            printf("sql: %s 没有返回结果集", $sql);
            exit;
          }
          while ($row = $result->fetch_row()) {
            // printf("%s (%s) (%s) (%s)<br />", $row[0], $row[1], $row[2], $row[3]);
            $artid = $row[5];
            $classid = $row[6];
            $timestamp = $row[0];
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
                  <p><a class="link-light" href="index.php?classid=<?php echo $classid ?>"><?php echo $row[1]; ?></a></p>
                  <h2 class="title">
                    <!-- 文章标题  限定30个utf8字符...-->
                    <a class="link-dark" href="article.php?artid=<?php echo $artid ?>&classid=<?php echo $classid ?>">
                      <?php
                      $title = $row[2];
                      // 截取标题字符串保留前30个utf8字符
                      $showTitle = mb_strlen($title, 'utf-8') > 30 ? mb_substr($title,0,30,'utf-8') . "..." : $title;
                      // 关键词红色高亮
                      $showTitle = str_replace($qword,"<font color='red'>{$qword}</font>", $showTitle);
                      echo $showTitle;
                      ?></a>
                  </h2>
                </div>
              </div>
              <div class="content">
                <div class="content-left">
                  <?php
                  $img = $row[4];
                  if ($img !== "") {
                    $path = rtrim($_SERVER['DOCUMENT_ROOT'], "/") . $objectRoot.'/uploads/'.$img;
                    if (file_exists($path)) {
                      echo "<img class='thumb-img' src='./uploads/{$img}' alt='{$title}'/>";
                    }
                  }
                  ?>
                </div>
                <div class="content-right">
                  <?php
                  // 文章内容 限定260个utf-8个字符... //
                  // trim the ASCII control characters at the beginning of $binary
                  // (from 0 to 31 inclusive)
                  $content = ltrim($row[3], "\x00..\x1F");
                  $content = strip_tags($content);
                  // 显示文章内容长度
                  $step = 260;
                  $len = mb_strlen($content, 'utf-8');
                  if ($len > $step) {
                    // 查找到关键词在文章中的位置，以高亮显示
                    $startpos = 0;
                    $showContent = mb_substr($content,$startpos, $step, 'utf-8') . "...";
                    while ($startpos < $len) {
                      if (!mb_strpos($showContent, $qword)) {
                        $showContent = "..." . mb_substr($content, $startpos, $step, 'utf-8') . "...";
                        $startpos += $step;
                      } else {
                        break;
                      }
                    }
                    // 关键词没找到, 大小写不符?
                    if ($startpos >= $len) {
                      $showContent = mb_substr($content, 0, $step, 'utf-8') . "...";
                    }
                  } else {
                    $showContent = $content;
                  }
                  $showContent = str_replace($qword,"<font color='red'>{$qword}</font>", $showContent);
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
              <li class="previous <?php if ($hasPrev==="false") echo "disabled"; ?>"><a href="?q=<?php $qword?>&page=<?php printf("%d", $page - 1); ?>" onclick="return <?php echo $hasPrev ?>">< 上一页</a></li>
              <li class="first"><a href="?q=<?php echo $qword ?>&page=1" onclick="return <?php echo $hasPrev ?>">首页</a></li>
              <li class="last"><a href="?q=<?php echo $qword ?>&page=<?php echo "{$pageCount}"; ?>" onclick="return <?php echo $hasNext ?>">尾页</a></li>
              <li class="next <?php if ($hasNext==="false") echo "disabled"; ?>"><a href="?q=<?php echo $qword ?>&page=<?php printf("%d", $page + 1); ?>" onclick="return <?php echo $hasNext ?>">下一页 ></a></li>
            </ul>
          </nav>
        </div>
      </div>
      <aside class="article-sidebar">
        <!-- 热门资讯 -->
        <div class="panel">
          <div class="panel-heading">
            <h3 class="panel-title">热门资讯</h3>
          </div>
          <div class="panel-body">
            <?php
            $sql = "select id,title from article order by hot desc limit 6;";
            $result = $link->query($sql);
            if (!$result) {
              printf("query failed (%s): %s", $sql, $link->error);
              exit;
            }
            $i = 1;
            while ($row = $result->fetch_assoc()) {
              $title = $row['title'];
              // 标题最大取20个utf-8字符长度
              if (mb_strlen($title, 'utf-8') > 20) {
                $title = mb_substr($title, 0, 20, 'utf-8') . "...";
              }
              ?>
              <div class="media">
                <div class="media-left">
                  <span class="num"><?php echo $i; ?></span>
                </div>
                <div class="media-body">
                  <a class="link-dark" href="#"><?php echo $title ?></a>
                </div>
              </div>
              <?php
              $i++;
            }
            $result->close();
            ?>
          </div>
        </div>    <!-- panel -->
        
        <!-- 热门标签 -->
        <div class="panel">
          <div class="panel-heading">
            <h3 class="panel-title">热门标签</h3>
          </div>
          <div class="panel-body">
            <?php
            $sql = "select tagname from tag limit 10;";
            $result = $link->query($sql);
            while ($row = $result->fetch_row()) {
              echo "<a class=\"btn-tag\" href=\"#\">{$row[0]}</a>";
            }
            $result->free();
            ?>
          </div>
        </div>
        
        <!-- 推荐资讯 -->
        <div class="panel">
          <div class="panel-heading">
            <h3 class="panel-title">推荐资讯</h3>
          </div>
          <div class="panel-body">
            <?php
            // @recommend: １- 不推荐 2 - 推荐
            $sql = "select `title` from `article` where `recommend`=2 order by `time` desc limit 6;";
            $result = $link->query($sql);
            $i = 0;
            while ($row = $result->fetch_assoc()) {
              $title = trim($row['title']);
              ?>
              <div class="media">
                <div class="media-left">
                  <span class="num"><?php echo ++$i; ?></span>
                </div>
                <div class="media-body">
                  <a class="link-dark" href="#"><?php echo $title; ?></a>
                </div>
              </div>
              <?php
            }
            $result->free_result();
            ?>
          </div>
        </div>
        
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

