<?php
if (!$_POST) {
    die("不是通过post提交");
}
include ('../../public/dbconnect.php');

$class = $_POST;
$classid = $class['classid'];

$str = "";
foreach($class as $key => $value) {
    $value = $link->escape_string($value);
    $str .= $key . "='" . $value . "',";
}
$str = rtrim($str, ',');

$sql = "UPDATE `class` SET {$str} WHERE classid={$classid}";
$res = $link->query($sql);
if ($res == TRUE) {
    echo "<script>window.location.href='./class.php'</script>";
} else {
    echo "<script>alert('修改失败')</script>";
    echo "<script>window.history.back()</script>";
}
$link->close();

?>

