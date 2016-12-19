<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/27/16
 * Time: 4:35 PM
 */
?>
<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">热门资讯</h3>
  </div>
  <div class="panel-body">
    <?php
    $sql = "select id,title from article order by hot desc limit 6;";
    $result = $link->query($sql);
    if (!$result) {
      printf("query failed (%s): %s", $sql, $link->error);
      exit;
    }
    $i = 1;
    while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $title = ltrim($row['title']);
      // 标题最大取20个utf-8字符长度
      if (mb_strlen($title, 'utf-8') > 20) {
        $title = mb_substr($title, 0, 20, 'utf-8') . "...";
      }
      ?>
      <div class="media">
        <div class="media-left">
          <span class="num"><?php echo $i; ?></span>
        </div>
        <div class="media-body">
          <a class="link-dark" href="<?php echo rtrim($domain) . "/article.php?artid=" . $id ?>"><?php echo $title ?></a>
        </div>
      </div>
      <?php
      $i++;
    }
    $result->close();
    ?>
  </div>
</div>
