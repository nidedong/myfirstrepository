<?php

include_once "../fn.php";
is_login();
$page = "index";
// -- 文章数
$postsSql = "select count(*) as total from posts";
$postsTotal = my_query( $postsSql )[0]['total'];
// -- --草稿数
$draSql = "select count(*) as total from posts where status = 'drafted'";
$draTotal = my_query( $draSql )[0]['total'];
// -- 分类数
$cateSql = "select count(*) as total from categories";
$cateTotal = my_query( $cateSql )[0]['total'];
// -- 评论数
$comSql = "select count(*) as total from comments";
$comTotal = my_query( $comSql )[0]['total'];
// -- 待审核数
$heldSql = "select count(*) as total from comments where status = 'held'";
$heldTotal = my_query( $heldSql )[0]['total'];
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once './inc/navbar.php'?>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $postsTotal?></strong>篇文章（<strong><?php echo $draTotal?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $cateTotal?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $comTotal?></strong>条评论（<strong><?php echo $heldTotal?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

  <?php include_once "./inc/aside.php"?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
