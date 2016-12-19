<?php include_once '../public/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>注册-学编程</title>
  <link rel="stylesheet" href="../css/register.css" type="text/css" />
</head>
<body>
<div class="es-wrap">
  <header class="es-header">
    <div class="index-header">
      <div class="navbar-header">
        <a href=<?php echo $domain."/index.php" ?>>
          <img src="../imgs/logo.jpg" height="50px" />
        </a>
      </div>
      <nav class="navbar-collapse">
        <form class="navbar-form" action="../search.php" method="get">
          <div class="form-group">
            <button class="button icon-search">
              <img src="../imgs/search.png" height="20px"/>
            </button>
            <input class="form-control" name="q" placeholder="搜索" />
          </div>
        </form>
        <div class="navbar-user">
          <ul class="nav user-nav">
            <li class="hidden-xs"><a href="login.php">登录</a></li>
            <li class="hidden-xs"><a href="register.php">注册</a></li>
          </ul>
        </div>
      </nav>
    </div>
  </header>

  <section class="index-nav">
    <nav class="navbar-collapse collapse" role="navigation">
      <ul class="nav navbar-nav">
        <li class="dropdown">全部课程
          <ul>
            <li><a href="#">前端开发</a></li>
            <li><a href="#">后端开发</a></li>
            <li><a href="#">移动开发</a></li>
            <li><a href="#">数据库</a></li>
          </ul>
        </li>
        <li class="dropdown">文章资讯
          <ul>
            <li><a href="<?php echo $domain ?>/index.php">技术文章</a></li>
            <li><a href="<?php echo $domain ?>/index.php">行业资讯</a></li>
          </ul>
        </li>
        <li><a href="#">学习小组</a></li>
        <li><a href="#">捐献本站</a></li>
      </ul>
    </nav>
  </section>

  <div id="content-container" class="container">
    <div class="es-section login-section">
      <div class="login-tab clearfix">
        <!-- 点击登录帐号标签 跳转到login.php -->
        <div class="tab" onclick="location.href='login.php'"><a href="login.php">登录帐号</a></div>
        <div class="tab active" onclick="location.href='register.php'"><a href="register.php">注册帐号</a></div>
      </div>

      <div class="login-main">
        <!-- 登录表单 提交到login_do.php -->
        <form class="" id="login-form" action="login_do.php" method="post">
          <!-- <div class="alert alert-danger">账号或密码不正确</div> -->
          <div class="form-group mbl">
            <div class="form-group has-error">   <!-- has-error / in-focus -->
              <label class="control-label required" for="login_username">账号</label>
              <div class="controls">
                <input id="login-username" class="form-control input-lg" type="text" placeholder="邮箱/手机/用户名" required="required" name="_username" data-explain="" />
                <p class="help-block">
                  <!-- <span class="text-danger">请输入账号</span> -->
                </p>
              </div>
            </div>
          </div>

          <div class="form-group mbl has-error">
            <label class="control-label required" for="login_password">密码</label>
            <div class="controls">
              <input id="login_password" class="form-control input-lg" type="password" placeholder="密码" required="required" name="password" />
              <p class="help-block">
                <!-- <span class="text-danger">请输入密码</span> -->
              </p>
            </div>
          </div>

          <div class="form-group mbl">
            <div class="controls">
              <button id="login-btn" class="btn btn-primary btn-lg btn-lock" data-submiting-text="正在登录" type="submit">登录</button>
            </div>
          </div>

        </form>
        <!-- END 登录表单 -->

        <!-- 注册表单 -->
        <form class="show" id="register-form" action="register_do.php" method="post" onsubmit="return checkForm()">

          <div class="form-group mbl">
            <div class="form-group has-error">   <!-- has-error / in-focus -->
              <label class="control-label required" for="emailOrmobile">手机/邮箱</label>
              <div class="controls">
                <input id="emailOrmobile" class="form-control input-lg" type="text" placeholder="请填写你常用的邮箱或手机号作为登录帐号" required="required" name="emailOrMobile" autofocus />
                <p class="help-block"></p>
                <!-- <span class="text-danger">请输入手机/邮箱</span> -->
              </div>
            </div>
          </div>

          <div class="form-group mbl">
            <div class="form-group has-error">
              <label class="control-label required" for="register_nickname">用户名</label>
              <div class="controls">
                <input id="register_nickname" class="form-control input-lg" type="text" placeholder="中、英文均可，最长18个英文或9个汉字" required="required" name="nickname" data-widget-cid="widget-4" data-explain="" />
                <p class="help-block"></p>
                <!-- <span class="text-danger">请输入用户名</span> -->
              </div>
            </div>
          </div>

          <div class="form-group mbl has-error">
            <label class="control-label required" for="register_password">密码</label>
            <div class="controls">
              <input id="register_password" class="form-control input-lg" type="password" placeholder="5-20位英文，数字，符号，区分大小写" required="required" name="password" maxlength="20" />
              <p class="help-block"></p>
              <!-- <span class="text-danger">请输入密码</span> -->
            </div>
          </div>

          <div class="form-group mbl js-captcha">
            <label class="control-label required" for="captcha_code">验证码
            </label>
            <div class="controls row">
              <input id="captcha_code" class="form-control input-lg" type="text"  required="required" placeholder="验证码" maxlength="5" name="captcha_code">
              <img id="getcode_num" src="./code.php" title="看不清，点击换一张" />
              <p class="help-block">
                <!-- <span class="text-danger">请输入验证码</span> -->
              </p>
            </div>
          </div>

          <div class="form-group mbl">
            <div class="controls">
              <button id="register-btn" class="btn btn-primary btn-lg btn-lock" data-submiting-text="正在提交" type="submit">注册</button>
            </div>
          </div>

        </form>
        <!-- 注册表单 END -->
      </div>
    </div>
  </div>
  <!-- footer -->
  <?php include '../public/footer.php' ?>
</div>
</body>
<script type="text/javascript" src="../js/validate.js"></script>
</html>
