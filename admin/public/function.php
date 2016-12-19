<?php
// @$file: $_FILES['pic'];
function upload($file, $path = null, $type = array('image/png', 'image/jpeg', 'image/gif')) {
  if (is_uploaded_file($file['tmp_name'])) {
    // 限制文件类型为图片
    if (!in_array($file['type'], $type)) {
      return false;
    }
    /* 限制文件大小 < 10M */
    if ($file['size'] > 10485760) {
      return false;
    }
    // 生成上传之后文件名
    $filename = date('YmdHis') . rand(100,999);
    $parts = explode('.', $file['name']);
    $ext = array_pop($parts);
    $filename = $filename . '.' . $ext;
    // 生成上传之后文件路径
    if (is_null($path)) {
      // $path = $_SERVER['DOCUMENT_ROOT'] . '/object/uploads/';
      // __DIR__: /opt/lampp/htdocs/project/admin/public
      $path = realpath(__DIR__ . "/../../uploads") . "/";
      $returnFile = $filename;
    } else {
      $path = rtrim($path, '/') . '/';
      $returnFile = $path . $filename;
    }
    $filePath = $path . $filename;
    // 确保文件是有效的上传文件
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
      return $returnFile;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

?>
