<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>后台管理登录</title>
    <link href="css/admin_login.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div class="admin_login_wrap">
      <h1>后台管理</h1>
      <div class="adming_login_border">
        <div class="admin_input">
          <form action="./do_login.php" method="post">
            <ul class="admin_items">
              <li>
                <label for="user">用户名：</label>
                <input type="text" tabindex="2" name="username" value="admin" id="user" size="40" class="admin_input_style" />
              </li>
              <li>
                <label for="pwd">密码：</label>
                <input type="password" tabindex="3" name="pwd" value="admin" id="pwd" size="40" class="admin_input_style" />
              </li>
              <li>
                <input type="submit" tabindex="1" value="提交" class="btn btn-primary" />
              </li>
            </ul>
          </form>
        </div>
      </div>
      <p class="admin_copyright"><a tabindex="5" href="#">返回首页</a> &copy; 2014 Powered by <a href="http://jscss.me" target="_blank">有主机上线</a></p>
    </div>
  </body>
</html>