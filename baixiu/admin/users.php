<?php

include_once "../fn.php";
is_login();
$page = "users";
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body dataId=<?php echo $_SESSION['user_id']?>>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once './inc/navbar.php'?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id="form">
            <h2>添加新用户</h2>
            <input type="hidden" name="id" id="id">
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码">
            </div>
            <div class="form-group">              
              <input class="btn btn-primary btn-add" type="button" value="添加">
              <input class="btn btn-primary btn-update" type="button" value="修改" style="display: none;">
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td class="text-center"><img class="avatar" src="../assets/img/default.png"></td>
                <td>i@zce.me</td>
                <td>zce</td>
                <td>汪磊</td>
                <td>激活</td>
                <td class="text-center">
                  <a href="post-add.php" class="btn btn-default btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php include_once "./inc/aside.php"?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script id="tpl" type="text/html">
    {{ each list v i }}
      <tr>
        <td class="text-center"><input type="checkbox" {{ v.id == dataId ? 'disabled' : ''}}></td>
        <td class="text-center"><img class="avatar" src="{{ v.avatar }}"></td>
        <td>{{ v.email }}</td>
        <td>{{ v.slug }}</td>
        <td>{{ v.nickname }}</td>
        <td>激活</td>
        <td class="text-left" dataId="{{ v.id }}">
          <a href="javascript:;" class="btn btn-default btn-xs btn-edit">编辑</a>
          {{ if v.id != dataId }}
          <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
          {{ /if }}
        </td>
      </tr>
    {{ /each }}
  </script>

  <script>
    $(function() {
      function render() {
        $.ajax({
          url: "./users/usersGet.php",
          dataType: "json",
          success: function( info ) {
            var obj = {
              list: info,
              dataId: $("body").attr("dataId")
            }
            console.log( obj );
            var htmlStr = template("tpl", obj);
            $("tbody").html( htmlStr );
          }
        })
      }
      render();

      //编辑功能
      $("tbody").on("click", ".btn-edit", function() {
        var id = $(this).parent().attr("dataId");
        $.ajax({
          url: "./users/usersGetOne.php",
          data: {
            dataId: id
          },
          dataType: "json",
          success: function( info ) {
            $("#email").val( info.email );
            $("#slug").val( info.slug );
            $("#nickname").val( info.nickname );
            $("#password").val( info.password );
            $(".btn-update").show();
            $(".btn-add").hide();
            $("#id").val( info.id );
          }
        })
      })
      //修改功能
      $(".btn-update").on("click", function() {
        var str = $("#form").serialize();
        console.log(str);
        $.ajax({
          url: "./users/usersUpdate.php",
          data: str,
          success: function( info ) {
            render();
            $("#form")[0].reset();
            $(".btn-update").hide();
            $(".btn-add").show();
          }
        })
      })

      //添加功能
      $(".btn-add").on("click", function() {
        var str = $("#form").serialize();
        console.log( str );
        $.ajax({
          type: "post",
          url: "./users/usersAdd.php",
          data: str,
          success: function( info ) {
            render();
            $("#form")[0].reset();
          }
        })
      })
    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
