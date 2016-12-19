<?php
include ('../../public/dbconnect.php');

$classid = intval($_GET['classid']);
$pid = intval($_GET['pid']);

//是一级分类，　删除这个分类和下面的二级分类
if ($pid === 0) {
    $sql = "DELETE FROM `class` WHERE `classid`= {$classid} OR `pid`={$classid}";
} else {
    $sql = "DELETE FROM `class` WHERE `classid`= {$classid}";
}
if ($link->query($sql) === TRUE) {
    echo "<script>window.location.href='./class.php?search-sort={$pid}'</script>";
} else {
    echo "Error deleting record: ' . $link->error";
}

$link->close();

?>
