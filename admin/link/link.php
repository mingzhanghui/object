<?php
include_once '../../public/config.php';
include '../public/acl.php';
include '../../public/dbconnect.php';
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title>后台管理 - 友情链接</title>
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
      <div class="crumb-list"><i class="icon-font"></i><a href="../index.php">首页</a><span class="crumb-step">&gt;</span>
        <span class="crumb-name">友情链接</span>
      </div>
    </div>
    <div class="search-wrap">
      <div class="search-content">
        <form action="link.php" method="post">
          <table class="search-tab">
            <tr>
              <th width="120">选择分类:</th>
              <td>
                <select name="search-sort" id="select-pass">
                  <option value="">全部</option>
                  <option value="LOGO链接">LOGO链接</option><option value="文字链接">文字链接</option>
                </select>
              </td>
              <th width="70">关键字:</th>
              <td><input class="common-text" placeholder="关键字" name="keywords" value="" id="" type="text"></td>
              <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
    <div class="result-wrap">
      <form name="myform" id="myform" method="post">
        <div class="result-title">
          <div class="result-list">
            <a href="addLink.php"><i class="icon-font"></i>新增链接</a>
            <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
            <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
          </div>
        </div>
        <div class="result-content">
          <table class="result-tab" width="100%">
            <tr>
              <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
              <!-- <th>排序</th>-->
              <th>ID</th>
              <th>链接类型</th>
              <th>网站名称</th>
              <th>URL</th>
              <th>联系人</th>
              <th>LOGO</th>
              <th>是否推荐</th>
              <th>审核状态</th>
              <th>操作</th>
            </tr>
            <?php
            $sql = "select id,`type`,sitename,siteurl,contact,pic,recommend,pass from link order by id desc";
            $res = $link->query($sql);
            while (list($id, $type, $sitename, $siteurl, $contact, $pic, $recommend, $pass) = $res->fetch_row()) {
              ?>
            <tr>
              <td class="tc"><input name="id[]" value="" type="checkbox"></td>
<!-- <td><input name="ids[]" value="59" type="hidden"><input class="common-input sort-input" name="ord[]" value="0" type="text"></td>-->
              <td title="ID"><?php echo $id ?></td>
              <td title="链接类型"><?php echo $type ?></td>
              <td title="网站名称"><a target="_blank" href="mod_link.php?id=<?php echo $id ?>" title="<?php echo $siteurl ?>"><?php echo $sitename ?></a></td>
              <td title="<?php echo $siteurl ?>"><a target="_blank" href="<?php echo $siteurl ?>"><?php echo strlen($siteurl) > 16 ? $siteurl . "..." : $siteurl ?></a></td>
              <td title="联系人"><?php echo $contact ?></td>
              <td title="LOGO图片">
                <?php
                if ($type === '文字链接') {echo "-";}
                else {echo "<img src='../../uploads/{$pic}' alt='{$sitename}' width='50px' />";}
                ?>
              </td>
              <td title="是否推荐"><?php echo ($recommend === 2) ?  "是" : "否"; ?></td>
              <td title="审核状态"><?php echo ($pass === 1)? "通过" : "未通过" ?></td>
              <td>
                <a class="link-update" href="mod_link.php?id=<?php echo $id ?>">修改</a>
                <a class="link-del" href="del_link.php?id=<?php echo $id ?>">删除</a>
              </td>
            </tr>
              <?php
            }
            ?>

          </table>
          <div class="list-page"> 2 条 1/1 页</div>
        </div>
      </form>
    </div>
  </div>
  <!--/main-->
</div>
</body>
</html>
<script type="text/javascript" src="../js/select.js"></script>