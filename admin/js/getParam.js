/**
 * Created by mzh on 11/1/16.
 */
function getQueryString() {
    if (1 < document.location.search.length) {
        //获取的字符串?后第一个字母
        var query = document.location.search.substring(1);
        // 用&分割字符串
        var parameters = query.split('&');

        var result = new Object();
        for (var i = 0; i < parameters.length; i++) {
        //  parameter name - value 分割
            var element = parameters[i].split('=');

            var paramName = decodeURIComponent(element[0]);
            var paramValue = decodeURIComponent(element[1]);

            // 增加关联数组参数名称作为key
            result[paramName] = decodeURIComponent(paramValue);
        }
        return result;
    }
    return null;
}

window.onload = function onLoad() {
    param = getQueryString();
    target = document.getElementById("param");
    target.value = param["artid"];
    console.log(target.value);
    // console.log("get artid=" + target.value);
}
