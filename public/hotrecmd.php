<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/27/16
 * Time: 4:41 PM
 */
?>
<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">推荐资讯</h3>
  </div>
  <div class="panel-body">
    <?php
    // @recommend: １- 不推荐 2 - 推荐
    $sql = "select `id`,`title` from `article` where `recommend`=2 order by `time` desc limit 6;";
    $result = $link->query($sql);
    $i = 0;
    while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $title = trim($row['title']);
      ?>
      <div class="media">
        <div class="media-left">
          <span class="num"><?php echo ++$i; ?></span>
        </div>
        <div class="media-body">
          <a class="link-dark" href="<?php echo rtrim($domain, "/") . "/article.php?artid=" . $id ?>"><?php echo $title; ?></a>
        </div>
      </div>
      <?php
    }
    $result->free_result();
    ?>
  </div>
</div>

