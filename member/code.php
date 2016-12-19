<?php

function create_code_image($w = 240, $h = 100, $n = 4) {
  /* 创建验证码背景 */
  $image = imagecreatetruecolor($w, $h);
  $color = imagecolorallocate($image, rand(128, 255), rand(128, 255), rand(128, 255));
  imagefill($image, 0, 0, $color);

  /* 添加干扰点 */
  for ($i = 0; $i < 100; $i++) {
    imagesetpixel($image, rand(0,255),rand(0,255),rand(0,255));
  }
  /* 添加干扰线 */
  for ($i = 0; $i < 10; $i++) {
    $lineColor = imagecolorallocate(
      $image, rand(0,255),rand(0,255),rand(0,255));
    $x1 = rand(0, $w);
    $y1 = rand(0, $h);
    $x2 = rand(0, $w);
    $y2 = rand(0, $h);
    imageline($image, $x1, $y1, $x2, $y2, $lineColor);
  }

  /* 注册时使用的数字和大小写字母组成的4个字符验证码 */
  $str = "0123456789abcedfghijklmnopqrstuvwxyzABCEDFGHIJKLMNOPQRSTUVWXYZ";
  $len = strlen($str) - 1;

  $fontSize = $w/$n;
  $offset = ceil($fontSize * 0.7);  /* 字符偏移距离 */
  $y = ceil($h/2 + $fontSize/2);

  /* 初始化生成验证码字符串 */
  $code = "";

  /* 产生$n个随机字符 */
  for ($i = 0; $i < $n; $i++) {
    $fontColor = imagecolorallocate($image,rand(0,127),rand(0,127),rand(0,127));
    $text = $str[rand(0, $len)];
    $angle = rand(-30, 30);
    $x = $w/8 + $offset * $i;
    imagettftext($image, $fontSize, $angle, $x, $y, $fontColor, "../fonts/1.ttf", $text);
    $code .= $text;
  }
  
  /* 输出图片 */
  header("Content-Type: image/png");
  
  imagepng($image);
  imagedestroy($image);

  return $code;
}

/* 把生成的验证码字符串写入session */
session_start();
$_SESSION['captcha_code'] = create_code_image();

?>
