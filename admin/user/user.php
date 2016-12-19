<?php
include ("../public/acl.php");
include_once ("../../public/config.php");
include '../../public/dbconnect.php';
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>『有主机上线』后台管理</title>
  <link rel="stylesheet" type="text/css" href="../css/common.css"/>
  <link rel="stylesheet" type="text/css" href="../css/main.css"/>
  <script type="text/javascript" src="../js/libs/modernizr.min.js"></script>
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
      <div class="crumb-list">
        <i class="icon-font"></i><a href="../index.php">首页</a><span class="crumb-step">&gt;</span>
        <span class="crumb-name">用户管理</span>
      </div>
    </div>
    <div class="search-wrap">
      <div class="search-content">
        <form action="" method="post">
          <table class="search-tab">
            <tr>
              <th width="70">用户名:</th>
              <td>
                <input class="common-text" placeholder="用户名" name="username" value="<?php if (isset($_REQUEST['username'])) echo $_REQUEST['username'] ?>" type="text">
              </td>
              <th width="70">邮箱:</th>
              <td>
                <input class="common-text" placeholder="邮箱" name="email" value="<?php if (isset($_REQUEST['email'])) {echo $_REQUEST['email'];}  ?>" type="text">
              </td>
              <td>
                <input class="btn btn-primary btn2" name="sub" value="查询" type="submit">
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>
    <div class="result-wrap">
      <form name="myform" id="myform" method="post">
        <div class="result-title">
          <div class="result-list">
            <a href="addUser.php"><i class="icon-font"></i>新增用户</a>
            <a id="batchDel" href="javascript:batchDel('del_user.php')">
              <i class="icon-font"></i>批量删除</a>
          </div>
        </div>
        <div class="result-content">
          <table class="result-tab" width="100%">
            <tr>
              <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
              <th>ID</th>
              <th>用户名</th>
              <th>状态</th>
              <th>头像</th>
              <th>邮箱</th>
              <th>性别</th>
              <th>管理员</th>
              <th>注册时间</th>
              <th>操作</th>
            </tr>
            <?php
            // $search = $_POST ? $_POST : $_GET;
            $search = $_REQUEST;
            $where = "";
            if (isset($search['username']) && $search['username'] != '') {
              $where = "WHERE `username` LIKE '%{$search['username']}%'";
              if (isset($search['email']) && $search['email'] != '') {
                $where .= " AND `email` LIKE '%{$search['email']}%'";
              }
            } else {
              if (isset($search['email']) && $search['email'] != '') {
                $where = "WHERE `email` LIKE '%{$search['email']}%'";
              }
            }

            $sql = "SELECT COUNT(`id`) AS `count` FROM `user` {$where}";
            $res = $link->query($sql);
            $count = $res->fetch_assoc();
            $res->free();
            $total = $count['count'];
            $limit = 10;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;

            $pageCount = ceil($total / $limit);
            if ($page > $pageCount || $page < 1) {
              $page = 1;
            }
            $sqlLimit = 'LIMIT ' . ($page - 1) * $limit . ',' . $limit;

            $sql = "SELECT `id`,`username`,`email`,`status`,`isAdmin`,`sex`,`pic`,`createTime` FROM `user` {$where} order by `createTime` desc ".$sqlLimit;
            $res = $link->query($sql);
            $row = 0;
            while (list($id, $username,$email,$status,$isAdmin,$sex,$pic,$createTime) = $res->fetch_row()) {
              $row += 1;
              ?>
              <tr>
                <td class="tc"><input name="id[]" value="<?php echo $id ?>" type="checkbox"></td>
                <td title="id"><?php echo $id ?></td>
                <td title="username"><?php echo $username = htmlspecialchars($username); ?></td>
                <td title="status"><?php echo $status == 1 ? "开启" : "禁用" ?></td>
                <td title="pic">
                  <img src="../../uploads/<?php echo $pic ?>" width="30px"/>
                </td>
                <td title="email"><?php echo $email ?></td>
                <td title="sex"><?php echo $sex ?></td>
                <td title="isAdmin">
                  <!-- $isAmin = 1, 普通用户 -->
                  <?php echo $isAdmin == 1 ? "否" : "是" ?>
                </td>
                <td title="createTime">
                  <?php echo date('Y-m-d H:i:s', $createTime) ?>
                </td>
                <td title="操作">
                  <a class="link-update" href="./mod_user.php?id=<?php echo $id ?>">修改</a>
                  <a class="link-del" onclick="return confirm('确定删除这个用户吗？');"
                     href="./del_user.php?id=<?php echo $id ?>">删除</a>
                </td>
              </tr>
              <?php
            }
            ?>
          </table>
          <div class="list-page">
            <?php
            if (isset($search['username']) && $search['username'] != '') {
              $args = "username={$search['username']}&email={$search['email']}";
            } else {
              $args = "";
            }

            // 分页
            echo "共{$pageCount}页";
            if ($page > 1) {
              if ($args === "") {
                echo "<a href='?page=1'>首页</a>";
              } else {
                echo "<a href='?page=1&{$args}'>首页</a>";
              }
            }
            if ($page > 5) {
              $end = $page - 5;
            } else {
              $end = 1;
            }
            for ($i = $end; $i < $page; $i++) {
              if ($args === "") {
                echo "<a href='?page={$i}'>$i</a>";
              } else {
                echo "<a href='?page={$i}&{$args}'>$i</a>";
              }
            }
            echo "<a style='color:red'>{$page}</a>";
            if ($page < $pageCount - 5) {
              $end = $page + 5;
            } else {
              $end = $pageCount;
            }
            for ($i = $page + 1; $i <= $end; $i++) {
              if ($args === "") {
                echo "<a href='?page={$i}'>{$i}</a>";
              } else {
                echo "<a href='?page={$i}&{$args}'>{$i}</a>";
              }
            }
            if ($page < $pageCount) {
              if ($args === "") {
                echo "<a href='?page={$pageCount}'>尾页</a>";
              } else {
                echo "<a href='?page={$pageCount}&{$args}'>尾页</a>";
              }
            }
            ?>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--/main-->
</div>
</body>
<script type="text/javascript" src="../js/select.js"></script>
</html>
