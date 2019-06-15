<?php
  include_once "../fn.php";
  // session_start();
  $user_id = $_SESSION['user_id'];
  $sql = "select * from users where id = $user_id";
  $res = my_query( $sql )[0];
  $nickname = $res['nickname'];
  $avatar = $res['avatar'];
  $isPost = in_array( $page, ['posts', 'post-add', 'categories'] );
  $isSet = in_array( $page, ['nav-menus', 'slides', 'settings'] );
?>

<div class="aside">
    <div class="profile">
      <img class="avatar" src="<?php echo $avatar?>">
      <h3 class="name"><?php echo $nickname?></h3>
    </div>
    <ul class="nav">
      <li class="<?php echo $page === 'index' ? 'active' : ''?>">
        <a href="index1.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li class="<?php echo $isPost ? 'active' : ''?>">
        <a href="#menu-posts" data-toggle="collapse" class="<?php echo $isPost ? '' : 'collapsed'?>">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php echo $isPost ? 'in' : ''?>">
          <li class="<?php echo $page === 'posts' ? 'active' : ''?>"><a href="posts.php">所有文章</a></li>
          <li class="<?php echo $page === 'post-add' ? 'active' : ''?>"><a href="post-add.php">写文章</a></li>
          <li class="<?php echo $page === 'categories' ? 'active' : ''?>"><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li class="<?php echo $page === 'comments' ? 'active' : ''?>">
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li class="<?php echo $page === 'users' ? 'active' : ''?>">
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li class="<?php echo $isSet ? 'active' : ''?>">
        <a href="#menu-settings" class="<?php echo $isSet ? '' : 'collapsed'?>" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo $isSet ? 'in' : ''?>">
          <li class="<?php echo $page === 'nav-menus' ? 'active' : ''?>"><a href="nav-menus.php">导航菜单</a></li>
          <li class="<?php echo $page === 'slides' ? 'active' : ''?>"><a href="slides.php">图片轮播</a></li>
          <li class="<?php echo $page === 'settings' ? 'active' : ''?>"><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>