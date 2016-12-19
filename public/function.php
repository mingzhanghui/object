<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/30/16
 * Time: 4:34 PM
 */
// @$replyUser array
//Array
//(
//  [0] => Array
//  (
//    [0] => 1              --> user.id
//    [1] => user3          --> user.username
//    [2] => 20161024103738875.png --> user.pic
//  )
//  [1] => Array
//  (
//    [0] => 2
//    [1] => user4
//     [2] => 20160925103800556.jpg
//     ...
//  )
function getUserNameById($replyUser, $id) {
  foreach ($replyUser as $value) {
    if ($value[0] == $id) {
      return $value[1];
    }
  }
  return 'Unknown';
}
function getUserPicById($replyUser, $id) {
  foreach ($replyUser as $value) {
    if ($value[0] == $id) {
      if ($value[2] != '') {   // 上传了头像
        return "./uploads/" . $value[2];
      }
    }
  }
  return './imgs/avatar.png';  // 默认头像
}
// 计算$time到当前多长时间
function getReplyTimeInt($time) {
  $now = time();
  $interval = $now - $time;
  $result = '';
  if ($interval > 86400) {
    $result = floor($interval / 86400) . "天以前";
  } else if ($interval > 3600) {
    $result = floor($interval / 3600) . "小时以前";
  } else if ($interval > 60) {
    $result = floor($interval / 60) . "分钟以前";
  } else {
    $result = '刚刚';
  }
  return $result;
}
