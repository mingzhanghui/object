<?php include_once __DIR__ . "/config.php" ?>
<header class="es-header">
  <!-- xuebiancheng logo   -->
  <div class="container index-header">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo $domain; ?>">
        <img src="<?php echo $domain ?>/imgs/logo.jpg" width="120px" />
      </a>
    </div>
    <nav class="collapse navbar-collapse text-center">
      <!-- 页面顶端搜索框-->
      <form class="navbar-form hidden-xs hidden-sm" action="<?php echo $domain.'/search.php' ?>" method="get"
            onsubmit="if(this.q.value=='' || this.q.value=='搜索') {alert('请输入搜索关键词'); return false;}" >
        <div class="form-group">
          <input type="text" class="form-control" name="q" autocomplete="on" placeholder="搜索") tabindex="1" />
          <button class="button es-icon es-icon-search" tabindex="2">
            <img src="<?php echo $domain ?>/imgs/search.png" />
          </button>
        </div>
      </form>
      <!-- 右边上角注册登录, 或 用户名 退出 -->
      <div class="navbar-user">
        <ul class="nav user-nav">
          <!-- 如果用户登录这里显示用户头像   -->
          <?php
          if (isset($_SESSION['user'])) {
            echo "<li class=\"hidden-xs\">";
            echo "<a href='" . $domain . "/member/member.php?id={$_SESSION['user']['id']}'>";
            $user = $_SESSION['user'];
            if ($user['pic'] !== "") {
              $path = realpath(__DIR__ . "/../uploads/{$user['pic']}");
              if (file_exists($path)) {
                echo "<img class='avatar-thumb' src='" . $domain . "/uploads/{$user['pic']}' alt='{$user['username']}的头像'/>";
              } else {
                echo "<img class='avatar-thumb' src='" . $domain . "/imgs/avatar.png' alt='{$user['username']}的头像'/>";
              }
            } else {
              // 用户没有上传头像的默认头像
              echo "<img class='avatar-thumb' src='" . $domain . "/imgs/avatar.png' alt='{$user['username']}的头像'/>";
            }
            echo "</a>";
            echo "</li>";
          }
          ?>
          <li class="hidden-xs">
            <?php
            if (isset($_SESSION['user'])) {
              $user = $_SESSION['user'];
              echo "<a href='" . $domain . "/member/member.php?id={$user['id']}'>{$user['username']}</a>";
            } else {
              echo "<a href='" . $domain . "/member/login.php'>登录</a>";
            }
            ?>
          </li>
          <li class="hidden-xs">
            <?php
            if (isset($_SESSION['user'])) {
              echo "<a href='" . $domain . "/member/logout.php'>退出</a>";
            } else {
              echo "<a href='" . $domain . "/member/register.php'>注册</a>";
            }
            ?>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</header>
