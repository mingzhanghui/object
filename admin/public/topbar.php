<?php //var_dump($_SESSION['master']['username'])  ?>
<div class="topbar-inner clearfix">
  <div class="topbar-logo-wrap clearfix">
    <h1 class="topbar-logo none"><a href="index.php" class="navbar-brand">后台管理</a></h1>
    <ul class="navbar-list clearfix">
      <li><a class="on" href="<?php echo $domain; ?>/admin/index.php">首页</a></li>
      <!-- <li><a href="#" target="_blank">网站首页</a></li> -->
      <li><a href="<?php echo $domain; ?>/index.php" target="_blank">网站首页</a></li>
    </ul>
  </div>
  <div class="top-info-wrap">
    <ul class="top-info-list clearfix">
      <!--  TODO: 用户名链接， 修改密码链接不对    -->
      <li><a href="http://www.jscss.me"><?php echo $_SESSION['master']['username']; ?></a></li>
      <li><a href="http://www.jscss.me">修改密码</a></li>
      <li><a href="<?php echo $domain; ?>/admin/logout.php">退出</a></li>
    </ul>
  </div>
</div>
