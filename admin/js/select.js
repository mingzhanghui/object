// 全选，全不选
var checkAll = document.getElementsByClassName('allChoose')[0];
var options = document.getElementsByName("id[]");

checkAll.onclick = function() {
  for (var i = 0; i < options.length; i++) {
    options[i].checked = checkAll.checked;
  }
}

function createXMLHttpRequest() {
  var xmlHttp;
  if (window.ActiveXObject) {
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  } else if (window.XMLHttpRequest) {
    xmlHttp = new XMLHttpRequest();
  }
  return xmlHttp;
}

// 通过ID批量删除
function batchDel(rawURL, id) {
  // xxx.php?id=xxx, 默认参数名为id='id'
  var id = arguments[1] ? arguments[1] : 'id';
  var idArr = [];
  var hasChecked = false;  // 检查是否至少勾选一个id

  for (var i = 0; i < options.length; ) {
    if (true == options[i].checked) {
      idArr.push(options[i].value);
      hasChecked = true;
      // 删除页面上节点 <tr></tr> 一行记录
      console.log("id=" + options[i].value + " is to be removed");
      var nodeDel = options[i].parentNode.parentNode;
      nodeDel.parentNode.removeChild(nodeDel);
      // 删除了当前节点, 下一个节点取代当前位置, i不自增
    } else {
      i++;
    }
  }

  // 有id被选弹出确认删除prompt
  if (hasChecked) {
    if(false == confirm('确定要删除这些？')) {
      return;
    }
  } else {
    alert("至少勾选一个id");
  }

  for (var i = 0; i < idArr.length; i++) {
    var xmlHttp = createXMLHttpRequest();
    var param = "?" + id + "=" + idArr[i];
    var url = rawURL + param;
    console.log(url);

    xmlHttp.onreadystatechange = function() {
      if (xmlHttp.readyState == 4) {
        if (xmlHttp.status == 200) {
          // alert("batch delete successfully");
          // xmlHttp.responseText
        } else {
          alert("There was a problem delete entry");
        }
      }
    }
    xmlHttp.open("GET", url, true);
    xmlHttp.send("");
  }
}

