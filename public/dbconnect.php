<?php
define('MYSQL_HOST', 'localhost');
define('MYSQL_USERNAME', 'root');
define('MYSQL_PASSWORD', '');
define('MYSQL_DATABASE', 'jkxy');

error_reporting(E_ALL);

date_default_timezone_set('Asia/Shanghai');

function connectdb() {
    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    if ($mysqli->connect_errno) {
        printf("Unable to connect to DB: %s, errno=%d\n", $mysqli->error, $mysqli->errno);
        exit();
    }
    if (!$mysqli->set_charset("utf8")) {
        printf("Error loading character set utf8: %s\n", $mysqli->error);
        exit();
    }
    return $mysqli;
}

$link = connectdb();

?>
