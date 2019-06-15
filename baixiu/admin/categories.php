<?php

include_once "../fn.php";
is_login();
$page = "categories";
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id="form">
            <h2>添加新分类目录</h2>
            <input type="hidden" name="id" id="id">
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">              
              <input type="button" class="btn btn-primary btn-add" value="添加">
              <input type="button" class="btn btn-primary btn-update" value="修改" style="display: none;">
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
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
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

  <script type="text/html" id="tpl">
    {{ each list v i}}
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>{{ v.name }}</td>
      <td>{{ v.slug }}</td>
      <td class="text-center" data-id="{{ v.id }}">
        <a href="javascript:;" class="btn btn-info btn-xs btn-edit">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
      </td>
    </tr>
    {{ /each }}
  </script>
  <script>
    function render() {
      $.ajax({
        url: "./categories/cateGet.php",
        dataType: "json",
        success: function( info ) {
          var obj = {
            list: info
          }
          var htmlStr = template("tpl", obj);
          $("tbody").html( htmlStr );
        }
      })
    }
    render();
    $(".btn-add").on("click", function() {
      var form = $("#form").serialize();
      $.ajax({
        url: "./categories/cateAdd.php",
        data: form,
        success: function( info ) {
          render();
          $("#form")[0].reset();
        }
      })
    })

    $("tbody").on("click", ".btn-del", function() {
      $.ajax({
        url: "./categories/cateDel.php",
        dataType: "json",
        data: {
          dataId: $(this).parent().attr("data-id")
        },
        success: function( info ) {
          console.log( info );
          render();
        }
      })
    })

    $("tbody").on("click", ".btn-edit", function() {
      var id = $(this).parent().attr("data-id");
      console.log( id );
      $.ajax({
        url: "./categories/cateGetOne.php",
        data: {
          dataId: id
        },
        dataType: "json",
        success: function( info ) {
          console.log( info );
          $("#name").val( info.name );
          $("#slug").val( info.slug );
          $(".btn-add").hide();
          $(".btn-update").show();
          $("#id").val( info.id );
        }
      })
    })

    $(".btn-update").on("click", function() {
      var str = $("#form").serialize();
      console.log( str );
      $.ajax({
        url: "./categories/cateUpdate.php",
        data: str,
        success: function( info ) {
          console.log( info );
          render();
          $("#form")[0].reset();
          $(".btn-update").hide();
          $(".btn-add").show();
        }
      })
    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
