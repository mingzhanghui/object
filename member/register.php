<?php
include_once('index.php');
?>
<!-- 切换注册标签 -->
<script type="text/javascript">
 var tabs = document.getElementsByClassName('tab');
 var contents = document.getElementsByClassName('login-main')[0].getElementsByTagName('form');
 /*登录 */
 tabs[0].className = 'tab';
 contents[0].className = '';
 /* 注册 */
 tabs[1].className = 'tab active';
 contents[1].className = 'show';
</script>

