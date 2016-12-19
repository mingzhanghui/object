<?php
include_once './public/acl.php';
//var_dump($_SESSION);
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title>『有主机上线』后台管理</title>
  <link rel="stylesheet" type="text/css" href="css/common.css"/>
  <link rel="stylesheet" type="text/css" href="css/main.css"/>
  <script type="text/javascript" src="js/libs/modernizr.min.js"></script>
  <script type="text/javascript" src="js/gettime.js"></script>
</head>
<body onload="">
<div class="topbar-wrap white">
  <?php
  include("./public/topbar.php");
  ?>
</div>
<div class="container clearfix">
  <?php
  include("./public/sidebar.php");
  ?>
  <!--/sidebar-->
  <div class="main-wrap">
    <div class="crumb-wrap">
      <div class="crumb-list"><i class="icon-font">&#xe06b;</i><span>欢迎使用『有主机上线』后台，建站的首选工具。</span></div>
    </div>
    <div class="result-wrap">
      <div class="result-title">
        <h1>快捷操作</h1>
      </div>
      <div class="result-content">
        <div class="short-wrap">
          <a href="./article/addArticle.php"><i class="icon-font">&#xe005;</i>新增博文</a>
          <a href="./class/addClass.php?pid=0"><i class="icon-font">&#xe041;</i>新增博客分类</a>
          <a href="./comment/replyComment.php"><i class="icon-font">&#xe01e;</i>回复评论</a>
        </div>
      </div>
    </div>
    <div class="result-wrap">
      <div class="result-title">
        <h1>系统基本信息</h1>
      </div>
      <div class="result-content">
        <ul class="sys-info-list">
          <li>
            <label class="res-lab">操作系统</label><span class="res-info"><?php echo PHP_OS; ?></span>
          </li>
          <li>
            <label class="res-lab">运行环境</label><span class="res-info"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></span>
          </li>
          <li>
            <label class="res-lab">PHP运行方式</label><span class="res-info"><?php echo php_sapi_name(); ?></span>
          </li>
          <li>
            <label class="res-lab">静静设计-版本</label><span class="res-info">v-0.1</span>
          </li>
          <li>
            <label class="res-lab">上传附件限制</label><span class="res-info"><?php echo ini_get('upload_max_filesize'); ?> </span>
          </li>
          <li>
            <label class="res-lab">北京时间</label>
            <span class="res-info" id="js_showtime"></span>
          </li>
          <li>
            <label class="res-lab">服务器域名/IP</label>
                <span class="res-info">
                  <?php echo $_SERVER['HTTP_HOST']; ?>
                </span>
          </li>
          <li>
            <label class="res-lab">Host</label>
            <span class="res-info">
              <?php echo $_SERVER['SERVER_ADDR']; ?>
            </span>
          </li>
        </ul>
      </div>
    </div>
    <div class="result-wrap">
      <div class="result-title">
        <h1>使用帮助</h1>
      </div>
      <div class="result-content">
        <ul class="sys-info-list">
          <li>
            <label class="res-lab">官方交流网站：</label><span class="res-info"><a href="http://jscss.me/" title="有主机上线设计" target="_blank">jscss.me</a></span>
          </li>
          <li>
            <label class="res-lab">官方交流QQ群：</label><span class="res-info"><a class="qq-link" target="_blank" href="http://user.qzone.qq.com/913737303/infocenter?ptsig=fwuIGucgSq7VB3N8vMjtbG8F-lEbvyN44NaOi-8MrHw_"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="JS-前端开发" title="JS-前端开发"></a> </span>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!--/main-->
</div>
</body>
</html>
