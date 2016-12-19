$(document).ready(function() {
  $("#repwd").on("blur", function() {
    var pwd = $("#pwd").val();
    var repwd = $("#repwd").val();
    if (pwd !== repwd) {
      alert("两次填写密码不一致");
      // 清除密码和确认密码
      // $("#pwd").val("");
      // $("#repwd").val("");
      $("#pwd").focus().select();
    }
  });
});
