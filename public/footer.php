<?php
include_once __DIR__ . "/config.php";
include_once __DIR__ . "/dbconnect.php";

$sql = "select count(id) as c from link where type='LOGO链接'";
$res = $link->query($sql);
$row = $res->fetch_row();
$n1 = intval($row[0]);

$sql = "select count(id) as c from link where type='文字链接'";
$res = $link->query($sql);
$row = $res->fetch_row();
$n2 = intval($row[0]);

$max = ($n1 > $n2) ? $n1 : $n2;
// 每个友情链接宽100px, label 100px
$width = 100 * (1 + intval($max));
?>
<footer>
  <div class="link">
    <table width="<?php echo $width ?>px" border="0" cellspacing="0" cellpadding="2">
      <tbody>
      <tr>
        <?php
        if ($n1 > 0) {
          echo "<td><label>图片链接:</label></td>";
          $sql = "select siteurl as url, pic, sitename as name from link where type='LOGO链接'";
          $res = $link->query($sql);
          while(list($url, $pic, $name) = $res->fetch_row()) {
            if (!empty($url)) {
              echo "<td><a target='_blank' href=\"{$url}\"><img src=\"{$domain}/uploads/{$pic}\" alt=\"{$name}\"/></a></td>";
            }
          }
          $res->free_result();
        }
        ?>
      </tr>
      <tr>
        <?php
        if ($n2 > 0) {
          echo "<td><label>文字链接:</label></td>";
          $sql = "select siteurl as url, pic, sitename as name from link where type='文字链接'";
          $res = $link->query($sql);
          while(list($url, $pic, $name) = $res->fetch_row()) {
            if (!empty($url)) {
              echo "<td><a target='_blank' href=\"{$url}\">{$name}</a></td>";
            }
          }
          $res->free_result();
        }
        ?>
      </tr>
      </tbody>
    </table>
  </div>
  <p class="text-center">
      <a class="mlm" href="#">课程存档</a>
      课程内容版权均归
      <a href="/">学编程</a>
      所有
      <a href="http://www.miibeian.gov.cn/" target="_blank">京ICP备13042384号</a>
   </p>
</footer>
<?php $link->close() ?>