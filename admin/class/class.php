<?php
include_once '../../public/config.php';
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
                <i class="icon-font"></i>
                <a href="../index.php">首页</a>
                <span class="crumb-step">&gt;</span>
                <span class="crumb-name">作品管理</span>
            </div>
        </div>
        <div class="search-wrap">
            <div class="search-content">
              <!-- 改变下拉菜单自动提交表单-->
                <form action="class.php" method="get" onchange="this.submit()">
                    <table class="search-tab">
                        <tr>
                            <th width="120">选择分类:</th>
                            <td>
                                <!-- 选择分类下拉菜单 -->
                                <select name="search-sort" id="selectClass">
                                    <option value="0">顶级分类</option>
                                    <?php

                                    $sql = "SELECT `classid`,`classname` FROM `class` WHERE `pid` = 0";
                                    $res = $link->query($sql);
                                    // select 下拉菜单显示当前查询的分类名称
                                    if (!isset($_GET['search-sort'])) {
                                        $_GET['search-sort'] = 0;
                                    }
                                    // $pid 用于填充新增分类的父级分类ID
                                    $pid = 0;
                                    while (list($classid, $classname) = $res->fetch_row()) {
                                        $classname = htmlspecialchars(urldecode($classname));
                                        if ($_GET['search-sort'] == $classid) {
                                            $pid = $classid;
                                            echo "<option selected=\"selected\" value=\"{$classid}\">" . $classname . "</option>";
                                        } else {
                                            echo "<option value='" . $classid . "'>" . $classname . "</option>";
                                        }
                                    }
                                    $res->close();
                                    ?>
                                </select>
                            </td>
                          <!-- <td><input class="btn btn-primary btn2" name="" value="查询" type="submit"></td>-->
                          <td><input class="btn btn-primary btn2" name="" value="查询" type="hidden"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-title">
                    <div class="result-list">
                        <a href="addClass.php?pid=<?php echo $pid ?>"><i class="icon-font"></i>新增分类</a>
                        <a id="batchDel" href="javascript:batchDel('del_class.php', 'classid')">
                          <i class="icon-font"></i>批量删除</a>
                        <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th class="tc" width="5%">
                                <input type="checkbox" id="allChoose" class="allChoose" name=""/>
                            </th>
                            <th>排序</th>
                            <th>分类ID</th>
                            <th>分类名称</th>
                            <th>分类简介</th>
                            <th>操作</th>
                        </tr>
                        <?php
                        /* 父级分类ID */
                        if (isset($_GET['search-sort']) && $_GET['search-sort'] !== '') {
                            $pid = $_GET['search-sort'];
                        } else {
                            $pid = 0;   // 顶级分类
                        }
                        $sql = "SELECT `classid`,`classname`,`description` FROM `class` WHERE `pid`=" . $pid;
                        $res = $link->query($sql);
                        $count = 0;
                        while (list($classid, $classname, $description) = $res->fetch_row()) {
                            $classname = htmlspecialchars(urldecode($classname));
                            $description = htmlspecialchars($description);
                            ?>
                            <tr>
                                <td class="tc">
                                    <input name="id[]" value="<?php echo $classid ?>" type="checkbox">
                                </td>
                                <td>
                                    <input name="ids[]" value="59" type="hidden">
                                    <input class="common-input sort-input" name="ord[]" value="<?php $count++;
                                    echo $count; ?>" type="text">
                                </td>
                                <td><?php echo $classid ?></td>
                                <td title="<?php echo $classname ?>"><a target="_self"
                                   href="class.php?search-sort=<?php if ($pid == 0) echo $classid; else echo $pid ?>"
                                   title="<?php echo $classname ?>"><?php echo $classname ?></a>
                                </td>
                                <td title="<?php echo $description ?>">
                                    <?php echo $desc = mb_strlen($description, 'utf-8') > 45 ?
                                      mb_substr($description, 0, 45, 'utf-8') . "..." : $description; ?>
                                </td>
                                <td>
                                    <a class="link-update"
                             href="./mod_class.php?classid=<?php echo $classid; ?>&pid=<?php echo $pid ?>">修改</a>
                                    <a class="link-del" onclick="return confirm('确定删除这个分类吗？');"
                           href="./del_class.php?classid=<?php echo $classid; ?>&pid=<?php echo $pid ?>">删除</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <div class="list-page"> <?php echo $count ?> 条 1/1 页</div>
                </div>
            </form>
        </div>
    </div>
    <!--/main-->
</div>
</body>
</html>
<script type="text/javascript" src="../js/select.js"></script>
