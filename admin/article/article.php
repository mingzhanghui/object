<?php
include '../public/acl.php';
include '../../public/dbconnect.php';
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title>『有主机上线』后台管理</title>
  <link rel="stylesheet" type="text/css" href="../css/common.css"/>
  <link rel="stylesheet" type="text/css" href="../css/main.css"/>
  <script type="text/javascript" src="../js/libs/modernizr.min.js"></script>
<!--  <script src="../js/libs/jquery-3.1.0.slim.min.js"></script>-->
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
      <div class="crumb-list">
        <i class="icon-font"></i><a href="../index.php">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">作品管理</span>
      </div>
    </div>
    <div class="search-wrap">
      <div class="search-content">
        <?php
        /* 按条件查询的参数 */
        $args = "";
        /* 查询父级分类 */
        $sql = "SELECT `classid`,`classname`,`pid` FROM `class` WHERE `pid`=0";
        $res = $link->query($sql);
        ?>
        <form action="article.php" method="get">
          <table class="search-tab">
            <tr>
              <th width="120">选择分类:</th>
              <td>
                <select name="classid" id="">
                  <option value="0">全部</option>
                  <?php
                  // select 下拉菜单显示当前查询的分类id
                  if (!isset($_GET['classid'])) {
                    $_GET['classid'] = 0;    // 全部分类
                  }
                  while (list($classid, $classname, $pid) = $res->fetch_row()) {
                    $classname = htmlspecialchars($classname);
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
                      $classname = htmlspecialchars($classname);
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
              </td>
              <th width="70">关键字:</th>
              <td><input class="common-text" placeholder="关键字" name="keywords"
                         value="<?php if (isset($_GET['keywords'])) { echo $_GET['keywords']; } ?>" id="" type="text"></td>
              <td><input class="btn btn-primary btn2" name="" value="查询" type="submit"></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
    <div class="result-wrap">
      <form name="myform" id="myform" method="GET">
        <div class="result-title">
          <div class="result-list">
            <a href="addArticle.php"><i class="icon-font"></i>新增博文</a>
            <!-- ref: ../js/select.js-->
            <!-- onclick="return confirm('确定要删除这些文章？')" -->
            <a id="batchDel" href="javascript:batchDel('del_article.php')"><i class="icon-font"></i>批量删除</a>
            <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
          </div>
        </div>
        <div class="result-content">
          <table class="result-tab" width="100%">
            <tr>
              <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
              <th>ID</th>
              <th>标题</th>
              <th>分类</th>
              <th>发布人</th>
              <th>更新时间</th>
              <th>是否推荐</th>
              <th>缩略图</th>
              <th>内容</th>
              <th>操作</th>
            </tr>
            <?php
            /* $where 关键字查找查询条件 */
            $where = "";

            $search = $_GET ? $_GET : $_POST;
            // 设置了分类, 不是 默认全部 - 顶级分类
            if (isset($search['classid']) && $search['classid'] != '0') {
              // 对于一级分类，找到对应的二级分类的ID
              $sql = "SELECT classid FROM class WHERE pid='{$search['classid']}'";
              $res = $link->query($sql);
              if ($res->num_rows > 0) {
                $where = "WHERE `classid` IN (";
                while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
                  $where .= "'{$row['classid']}', ";
                }
                $where = rtrim($where, ", ") . ')';
              } else {
                $where = "WHERE `classid` = '{$search['classid']}'";
              }
              $res->free();

              // 输入了检索词
              if (isset($search['keywords']) && $search['keywords'] != '') {
                $where .= " AND `content` LIKE '%{$search['keywords']}%'";
              }
            }
            // 是顶级分类, 显示所有分类, where classid 条件为空
            else {
              if (isset($search['keywords']) && $search['keywords'] != '') {
                $where = "WHERE `content` LIKE '%{$search['keywords']}%'";
              }
            }

            $sql = "SELECT COUNT(`id`) AS `count` FROM `article` {$where}";
            $res = $link->query($sql);
            $row = $res->fetch_assoc();
            $res->free();

            $total = $row['count'];
            /* 每一页显示多少条数据 */
            $limit = 6;
            /* 需要分多少页 */
            $pageCount = ceil($total / $limit);
            /* $page当前页数 GET传参page=?指定 */
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            if ($page > $pageCount || $page < 1) {
              $page = 1;
            }
            $sqlLimit = sprintf('LIMIT %d,%d', ($page-1) * $limit, $limit);

            $sql = "SELECT `id`,`title`,`classid`,`author`,`time`,`recommend`,`pic`,`content` FROM `article` {$where} order by id desc {$sqlLimit}";
            $res = $link->query($sql);

            while (list($id,$title,$classid,$author,$time,$recommend,$pic,$content) = $res->fetch_row()) {
              ?>
              <tr>
                <td class="tc"><input name="id[]" value="<?php echo $id; ?>" type="checkbox"></td>
                <!-- ID -->
                <td><?php echo $id; ?></td>
                <!-- 标题 title -->
<!--                <td title="--><?php //$title = htmlspecialchars($title); $showTitle = strlen($title) > 16 ? substr($title,0,16) . "..." : $title; echo $showTitle; ?><!--">-->
                <td title="<?php $title = htmlspecialchars($title); $showTitle = mb_strlen($title,'utf-8') > 16 ? mb_substr($title,0,16,'utf-8') . "..." : $title; echo $showTitle; ?>">
                  <a href="article_detail.php?artid=<?php echo $id ?>" alt="<?php echo $title ?>" title="<?php echo $title; ?>"><?php echo $showTitle; ?></a>
                </td>
                <!-- 文章分类 classid -> classname -->
                <td>
                  <?php
                  $sql = "SELECT `classname` FROM `class` WHERE `classid`={$classid}";
                  $result = $link->query($sql);
                  $row = $result->fetch_array(MYSQLI_ASSOC);
                  echo $row['classname'] == '' ? '未分类' : $row['classname'];
                  unset($row);
                  $result->free();
                  ?>
                </td>
                <!-- 发布人 author -->
                <td><?php echo $author; ?></td>
                <!-- 更新时间 time -->
                <td><?php echo date('Y-m-d H:i:s', $time); ?></td>
                <!-- @$recommend: 1 不推荐, 2 推荐  -->
                <td><?php echo ($recommend == 2) ? "是" : "否"; ?></td>
                <!-- 缩略图 pic-->
                <td><?php if ($pic !== '') {echo "<img src='../../uploads/{$pic}' width='50px' />";} ?></td>
                <!-- 内容 content -->
                <td class="result-tab-content"
                    title="<?php $content = htmlspecialchars($content); $trimmed = ltrim($content, " \t\r\n\t"); echo $trimmed; ?>">
                  <?php
                  echo mb_strlen($trimmed,'utf-8') < 20 ? $trimmed : mb_substr($trimmed, 0, 20) . '...';
                  ?>
                </td>
                <!-- 操作 -->
                <td>
                  <a class="link-update" href="./mod_article.php?id=<?php echo $id; ?>">修改</a>
                  <a class="link-del" onclick="return confirm('确定删除这个文章吗？');" href="./del_article.php?id=<?php echo $id ?>&page=<?php echo $page?>">删除</a>
                </td>
              </tr>
              <?php
            }
            ?>
          </table>
          <!--  分页开始   -->
          <div class="list-page">
            <?php
            if (isset($search['keywords']) && $search['keywords'] !== '') {
              $args = "classid={$search['classid']}&keywords={$search['keywords']}";
            } else {
              $args = "classid={$search['classid']}";
            }
            /* 显示 从$start开始页数到$end结束页数, $page当前页数 */
            function showPages($start = 1, $page = 1, $end = 10, $args='') {
              for ($i = $start; $i < $page; $i++) {
                echo "<a href='?page={$i}&{$args}'>$i</a>";
              }
              echo "<a style='color:red'>$page</a>";
              for ($i = $page + 1; $i <= $end; $i++) {
                echo "<a href='?page={$i}&{$args}'>$i</a>";
              }
            }
            echo "共 {$total} 条 第 {$page}/{$pageCount} 页";

            /* 跳转到第1页按钮 */
            if ($page > 1) {
              echo "<a href='?page=1&{$args}'>首页</a>";
              /* 上一页 <*/
              $prevPage = $page - 1;
              echo "<a href='?page={$prevPage}'><</a>";
            }
            /* 显示10个页号 */
            if ($pageCount <= 10) {
              showPages(1, $page, $pageCount, $args);
            } else {
              $start = $page - 5;
              if ($start < 1) {
                $start = 1;
              }
              /* $end最后一页 */
              $end = $page + 4;
              if ($end < 10) {
                $end = 10;
              }
              if ($end > $pageCount) {
                $end = $pageCount;
              }
              showPages($start, $page, $end, $args);
            }

            /* 下一页> */
            if ($page < $pageCount) {
              $nextPage = $page + 1;
              echo "<a href='?page={$nextPage}&{$args}'>></a>";
              echo "<a href='?page={$pageCount}&{$args}'>尾页</a>";
            }
            ?>
          </div>
          <!-- 分页结束 -->
        </div>
      </form>
    </div>
  </div>
  <!--/main-->
</div>
<script src="../js/select.js"></script>
</body>
</html>
<?php
$link->close();
?>
