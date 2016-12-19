/**
 * Created by mzh on 10/11/16.
 */
// 导航栏下进度条移动
function move() {
    var elem = document.getElementsByClassName("loading-length")[0];
    var width = 1;
    var id = setInterval(frame, 10);
    function frame() {
        if (width >= 100) {
            clearInterval(id);
        } else {
            width += 10;
            elem.style.width = width + '%';
        }
    }
}
window.onload = function () {
    return move();
}

//　选定搜索框边框颜色改变
var searchInput = document.getElementsByClassName("form-control")[0];
var outerbox = searchInput.parentNode;

searchInput.onfocus = function () {
    searchInput.style.border = "1px solid #fff";
    outerbox.style.border = "1px solid #0099ff";
}
searchInput.onblur = function () {
    outerbox.style.border = "1px solid #ccc";
}