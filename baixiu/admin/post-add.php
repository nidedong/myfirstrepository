<?php

include_once "../fn.php";
is_login();
$page = "post-add";
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
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
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" action="./posts/postsAdd.php" method="post" enctype="multipart/form-data">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <div id="content-box">
            
            </div>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容" style="display:none;"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none; width: 80px; height: 80px;">
            <input id="feature" class="form-control" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">

            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <!-- <option value="drafted">草稿</option> -->

            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary save" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php include_once "./inc/aside.php"?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/editor/wangEditor.min.js"></script>
  <script src="../assets/vendors/moment/moment.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>

  <script id="cateTpl" type="text/html">
    {{ each items v i }}
      <option value="{{ v.id }}">{{ v.name }}</option>
    {{ /each }}
  </script>

  <script id="stateTpl" type="text/html">
    {{ each state v k}}

      <option value="published">{{ v }}</option>
    {{ /each }}
  </script>
  <script>
    $(function() {
      //富文本编辑器
      var E = window.wangEditor;
      var editor = new E('#content-box');
      editor.customConfig.onchange = function(html) {
        $("textarea").val(html);
      }
      editor.create();

      //别名实时同步
      $("#slug").on("input", function() {
        $(".help-block > strong").text($(this).val() || "slug");

      })
      //图片实时预览
      $("#feature").on("change", function() {
        var file = this.files[0];
        var imgUrl = URL.createObjectURL(file);
        $(this).siblings("img").attr("src", imgUrl).show();
      })

      //获取当前时间
      var time = new Date();
      console.log(time);
      //日期格式化： 2017-07-03T02:05
      $("#created").val(moment(time).format("YYYY-MM-DDTHH:mm"));

      //获取分类
      $.ajax({
        url: "./categories/cateGet.php",
        dataType: "json",
        success: function( info ) {
          console.log(info);
          var obj = {
            items: info
          }
          var htmlStr = template("cateTpl", obj);
          $("#category").html( htmlStr );
        }
      })

      //获取状态
      var state = {
        drafted: "草稿",
        published: "已发布",
        trashed: "回收站"
      }
      $("#status").html( template("stateTpl", {state}) );


    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
