<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/27/16
 * Time: 4:38 PM
 */
?>
<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">热门标签</h3>
  </div>
  <div class="panel-body">
    <?php
    $sql = "select tagname from tag limit 10;";
    $result = $link->query($sql);
    while ($row = $result->fetch_row()) {
      echo "<a class=\"btn-tag\" href=\"#\">{$row[0]}</a>";
    }
    $result->free();
    ?>
  </div>
</div>

