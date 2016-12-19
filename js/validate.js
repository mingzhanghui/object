/* 注册表单验证 */
var registerForm = document.getElementById('register-form');

var inputs = registerForm.getElementsByTagName('input');

function isEmail(mail) {
  // 顶级域名只能是2,3个字符
  var pat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  return pat.test(mail.value);
}

function isMobile(number) {
  // 仅限中国手机号+86
  var pat = /^(\+86)?1[358][0-9]{9}$/;
  return pat.test(number.value);
}

function isUsername(name) {
  var pat = /^(\w){4,18}$/;
  return pat.test(name.value);
}

function isPassword(pwd) {
  var pat = /^(?=.{5,20})(?=.*[a-zA-Z])(.*\d)(.*[!@#$^&*()-_+=])$/;
  return pat.test(pwd.value);
}

document.forms['register-form']['emailOrMobile'].addEventListener('blur', validateMobileOrEmail, true);

function validateMobileOrEmail() {
  var obj = document.forms['register-form']['emailOrMobile'];
  var helpBlock = obj.nextElementSibling;
  
  if (obj.value === '') {
    helpBlock.innerHTML = "<span class='text-danger'>请输入手机号/邮箱</span>";
  } else {
    if (!isMobile(obj) && !isEmail(obj)) {
      helpBlock.innerHTML = "<span class='text-danger'>手机号码/邮箱地址不合法</span>";
      obj.focus;
    } else {
      helpBlock.innerHTML = "";
      return true;
    }
  }
  return false;
}


document.forms['register-form']['nickname'].addEventListener('blur', validateNickname, true);

//　TODO: 检验用户名已经存在
function validateNickname() {
  var obj = document.forms['register-form']['nickname'];
  var helpBlock = obj.nextElementSibling;
  if (obj.value === '') {
    helpBlock.innerHTML = "<span class='text-danger'>请输入用户名</span>";
    return false;
  }
  var len = obj.value.length;
  if (len < 4 || 18 < len) {
    helpBlock.innerHTML = "<span class='text-danger'>用户名必须4到18个字符</span>";
    return false;
  }
  if (!isUsername(obj)) {
    helpBlock.innerHTML = "<span class='text-danger'>用户名必须是中文字、英文字母、数字及下划线组成</span>";
    obj.focus;
    return false;
  }
  helpBlock.innerHTML = "";
  return true;
}

document.forms['register-form']['password'].addEventListener('blur', validatePassword, true);

function validatePassword() {
  var obj = document.forms['register-form']['password'];
  var helpBlock = obj.nextElementSibling;
  if (obj.value === '') {
    helpBlock.innerHTML = "<span class='text-danger'>请输入密码</span>";
    return false;
  }
  var len = obj.value.length;
  if (len < 5) {
    helpBlock.innerHTML = "<span class='text-danger'>密码的长度必须大于或等于5</span>";
    return false;
  } else if (20 < len) {
    helpBlock.innerHTML = "<span class='text-danger'>密码的长度必须小于或等于20</span>";
    return false;
  }
  helpBlock.innerHTML = "";

  return true;
}

function checkForm() {
  return validateMobileOrEmail() && validatePassword() && validatePassword();
}

/* 登录表单验证 */
var loginForm = document.getElementById('login-form');

function insertAlertDiv(form) {
  var createDiv = document.createElement("div");
  createDiv.innerHTML = "账号或密码不正确";
  createDiv.className = "alert alert-danger";
  form.insertBefore(createDiv, form.firstChild);
  return createDiv;
}
// var alertDiv = insertAlertDiv(loginForm);

document.forms['login-form']['_username'].onblur = function() {
  var helpBlock = this.nextElementSibling;
  if (this.value === '') {
    helpBlock.innerHTML = "<span class='text-danger'>请输入帐号</span>";
    return false;
  }
  helpBlock.innerHTML = "";
  return true;
}

document.forms['login-form']['password'].onblur = function() {
  var helpBlock = this.nextElementSibling;
  if (this.value == '') {
    helpBlock.innerHTML = "<span class='text-danger'>请输入密码</span>";
  } else {
    helpBlock.innerHTML = "";
  }
}

// 点击验证码图片刷新验证码
var code = document.getElementById("getcode_num");
code.onclick = function() {
  this.src += "?" + Math.random();
}

function checkCode(inputVal, helpBlock) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("POST", "check_code.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  // ajax发送用户输入的验证码
  xmlhttp.send("captcha_code=" + inputVal);
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      if (xmlhttp.responseText == "true") {
	helpBlock.innerHTML =
	  "<span class=''><font color='green'>验证码正确</font></span>";
      }
      else {
	helpBlock.innerHTML =
  	  "<span class='text-danger'>" + xmlhttp.responseText + "</span>";
      }
    }
  }
}

document.getElementById("captcha_code").oninput = function() {
  var helpBlock = this.nextElementSibling.nextElementSibling;
  if (this.value == '') {
    helpBlock.innerHTML = "<span class='text-danger'>请输入验证码</span>";
  } else {
    checkCode(this.value, helpBlock);
  }
}

