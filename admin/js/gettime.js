var xmlHttp;

function createXMLHttpRequest() {
  if (window.ActiveXObject) {
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  } else if (window.XMLHttpRequest) {
    xmlHttp = new XMLHttpRequest();
  }
}

// 发送服务器时间的URL ../public/gettime.php
// http://localhost/project/admin/index.php --> http://localhost/project/admin/public/gettime.php
function getUrl() {
  var url = window.location.href;
  var pos = url.lastIndexOf("/");
  url = url.substr(0, pos) + "/public/gettime.php";
  return url;
}

function startClock() {
  createXMLHttpRequest();
  var url = getUrl();
  xmlHttp.open("GET", url, true);
  xmlHttp.onreadystatechange = function() {
    if (xmlHttp.status == 200) {
      var str = xmlHttp.responseText;
      document.getElementById("js_showtime").innerHTML = str;
      setTimeout("startClock()", 999);
    }
  }
  xmlHttp.send(null);
}

window.onload = startClock();