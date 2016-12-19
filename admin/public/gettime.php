<?php
header("cache-control: no-cache, must-revalidate");
header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set("Asia/Shanghai");
$showtime = date('Y年m月d日 H:i:s');
echo $showtime;
?>
