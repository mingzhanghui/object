/**
 * Created by mzh on 10/31/16.
 */
var threadPostForm = document.getElementById("thread-post-form");
threadPostForm.onsubmit = function () {
    if (this.replyContent.value == '' || this.replyContent.value == '你的想法') {
        alert('发表评论内容不能为空');
        return false;
    }
}

// 点击回复a标签， 弹出或隐藏回复框
var threadPosts = document.getElementsByClassName("thread-post");
var replys = document.getElementsByClassName("js-reply");

function toggleHide(a, target) {
    target.classList.toggle("hide");
}

for (var i = 0; i < threadPosts.length; i++) {
    var a = replys[i];
    var target = threadPosts[i].lastChild.previousSibling.lastChild.previousSibling;
    if (a != undefined) {
        a.onclick = function(a, target) {
          return function () {
              toggleHide(a, target);
          }
        } (a, target); 
    }
}