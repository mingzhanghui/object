/**
 * Created by mzh on 11/3/16.
 */
// function getCookie(name) {
//     var reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
//     var arr;
//     if (arr = document.cookie.match(reg)) {
// 	return unescape(arr[2]);
//     } else {
// 	return null;
//     }
// }

function getCookieList(name) {
    // cookie entries "name1=value1; name2=value2; ..."
    var entries = document.cookie.split('; ');

    // at least 1 cookie entry
    if (entries.length > 0) {
        var result = new Object();
        for (var i = 0; i < entries.length; i++) {
            // split each entry by '='
            var element = entries[i].split('=');
            var paramName = decodeURIComponent(element[0]);
            var paramValue = decodeURIComponent(element[1]);
            // add to name-value array
            result[paramName] = decodeURIComponent(paramValue);
        }
        return result;
    }
    return null;
}
function getCookie(name) {
    return function () {
        param = getCookieList();
        return param[name];
    } (name);
}
