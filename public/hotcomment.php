<?php
/**
 * Created by PhpStorm.
 * User: mzh
 * Date: 10/27/16
 * Time: 4:39 PM
 */
// include_once "./public/dbconnect.php";   // 被../index.php引用
$sql = "select user.id as uid, user.username as `name`, user.pic as pic, comment.artid as artid, article.title as title, comment.replyContent as content from user inner join comment 
    on user.id=comment.replyUserID inner join article on article.id=comment.artid order by comment.replyTime desc limit 5;";
$res = $link->query($sql);
?>

<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">热门评论</h3>
  </div>
  <div class="panel-body">
    <?php
    while (list($uid, $name, $pic, $artid, $title, $content) = $res->fetch_row()) {
      $title = htmlspecialchars($title);
      $content = htmlspecialchars($content);
    ?>
    <div class="media media-hot-comment">
      <div class="media-body">
        <div class="pull-left">
          <!-- TODO: 跳转到其他用户信息页面 -->
          <a class="js-user-card" href="#" data-card-url="#" data-user-id="782">
            <?php
            if ($pic != '') {
              echo "<img class='avatar-sm' src='{$domain}/uploads/{$pic}' />";
            } else {
              echo "<img class=\"avatar-sm\" src=\"{$domain}/imgs/avatar.png\"/>";
            }
            ?>
          </a>
        </div>
        <div class="comments-info">
          <a class="link-dark" href="#"><?php echo $name ?></a>
          <span class="mhs">评论于</span>
          <a class="link-dark" href="article.php?artid=<?php echo $artid ?>"
             alt="<?php echo $title?>"><?php echo strlen($title) > 16 ? ($title . "...") : $title ?></a>
        </div>
        <div class="comments-content"><?php echo strlen($content) > 20 ? ($content . "...") : $content ?></div>
      </div>
    </div>
    <?php
    }
    ?>
  </div>
</div>

