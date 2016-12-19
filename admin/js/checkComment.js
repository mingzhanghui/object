/**
 * Created by mzh on 10/31/16.
 */
// 错误提示
var helpBlocks = document.getElementsByClassName("help-block");

var commentids = document.getElementsByClassName('commentids');
// 可以输入的评论ID
var commentidlist = [];
for (var i = 0; i < commentids.length; i++) {
    commentidlist.push(commentids[i].value);
}

// 检查输入的文章ID
var commentid = document.getElementById("commentid");
commentid.onfocus = function () {
    helpBlocks[0].innerText = '';
}
commentid.onblur = function () {
    if (commentid.value == '') {
        helpBlocks[0].innerText = '评论ID不能为空';
    } else {
        var i = 0;
        while (i < commentidlist.length) {
            if (commentidlist[i] == commentid.value) {break;}
            i++;
        }
        // 用户输入的ID不在范围内
        if (i == commentidlist.length) {
            helpBlocks[0].innerText = "评论ID="+ commentid.value + "不存在";
        }
    }
}
