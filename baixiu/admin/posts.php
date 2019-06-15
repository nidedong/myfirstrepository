<?php

include_once "../fn.php";
is_login();
$page = "posts";
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/vendors/jquery-pagination/pagination.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once './inc/navbar.php'?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm btn-dels" href="javascript:;" style="display: none">批量删除</a>
        <div class="page-box pull-right">

        </div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox" class="th-check"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->

        </tbody>
      </table>
    </div>
  </div>

  <?php include_once "./inc/aside.php"?>
  <?php include_once "./inc/edit.php"?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script src="../assets/vendors/jquery-pagination/jquery.pagination.js"></script>
  <script src="../assets/vendors/editor/wangEditor.min.js"></script>
  <script src="../assets/vendors/moment/moment.js"></script>

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
  <script id="tpl" type="text/html">
    {{each items v i}}
      <tr>
        <td class="text-center"><input type="checkbox" class="tb-check" dataId={{ v.id }}></td>
        <td>{{ v.title }}</td>
        <td>{{ v.author }}</td>
        <td>{{ v.class }}</td>
        <td class="text-center">{{ v.created }}</td>
        <td class="text-center">{{ state[v.status] }}</td>
        <td class="text-center" data-id="{{ v.id }}">
          <a href="javascript:;" class="btn btn-default btn-xs btn-edit">编辑</a>
          <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
        </td>
      </tr>
    {{/each}}
  </script>
  <script>
    $(function() {
      //渲染文章列表
      var currentPage = 1;
      function render(page, pageSize) {
        $.ajax({
          type: "get",
          url: "./posts/postsGet.php",
          dataType: "json",
          data: {
            page: page || 1,
            pageSize: pageSize || 10
          },
          success: function(info) {
            var obj = {
              items: info,
              state: {
                drafted: "草稿",
                published: "已发布",
                trashed: "回收站"
              }
            }
            var htmlStr = template("tpl", obj);
            $("tbody").html(htmlStr);
            $(".th-check").prop("checked", false);
            $(".btn-dels").hide();
          }
        })
      }
      render();
      //渲染上下页列表
      function setPage(page) {
        $.ajax({
          type: "get",
          url: "./posts/postsTotal.php",
          dataType: "json",
          success: function(info) {
            $(".page-box").pagination(info.total, {
              prev_text: "« 上一页",
              next_text: "下一页 »",
              items_per_page: 10,
              num_edge_entries: 1,       //两侧首尾分页条目数
              num_display_entries: 4,    //连续分页主体部分分页条目数
              current_page: page - 1 || 0,   //当前页索引
              load_first_page: false,
              callback: function(index) {
                currentPage = index + 1;
                render(index + 1);
              }
            });
          }

        })
      }
      setPage();

      //删除事件
      $("tbody").on("click", ".btn-del", function() {
        var id = $(this).parent().attr("data-id");
        $.ajax({
          url: "./posts/postsDel.php",
          dataType: "json",
          data: {
            dataId: id
          },
          success: function(info) {
            var maxPage = Math.ceil(info.total / 10);
            currentPage = currentPage > maxPage ? maxPage : currentPage;
            render(currentPage);
            setPage(currentPage)

          }
        })
      })
      //全选功能
      $(".th-check").on("click", function() {
        var flag = $(this).prop("checked");
        $(".tb-check").prop("checked", flag);
        if(flag) {
          $(".btn-dels").show();
        }else {
          $(".btn-dels").hide();
        }
      })
      //多选功能
      $("tbody").on("click", ".tb-check", function() {
        var total = $(".tb-check").length;
        var select = $(".tb-check:checked").length;
        $(".th-check").prop("checked", total === select);
        if(select >= 2) {
          $(".btn-dels").show();
        }else {
          $(".btn-dels").hide();
        }
      })
      //获取批量删除的数据id拼接成字符串
      function getIds() {
        var arr = [];
        $(".tb-check:checked").each(function() {
          var id = $(this).attr("dataId");
          arr.push(id);
        })
        return arr.join(",");
      }
      //批量删除
      $(".btn-dels").on("click", function() {
        $.ajax({
          url: "./posts/postsDel.php",
          dataType: "json",
          data: {
            dataId: getIds()
          },
          success: function(info) {
            $(".btn-dels").hide();
            $(".th-check").prop("checked", false);
            var maxPage = Math.ceil(info.total / 10);
            currentPage = currentPage > maxPage ? maxPage : currentPage;
            render(currentPage);
            setPage(currentPage);
          }
        })
      })
      
      //富文本编辑器
      var E = window.wangEditor;
      var editor = new E('#content-box');
      editor.customConfig.onchange = function (html) {
          // 监控变化，同步更新到 textarea
          $("#content").val(html)
      }
      editor.create();

      //别名同步
      $("#slug").on("input", function() {
        $("#strong").text( $(this).val() || "slug");
      })

      //图片预览
      $("#feature").on("change", function() {
        var file = this.files[0];
        var imgUrl = URL.createObjectURL( file );
        $("#img").attr("src", imgUrl);
      })

      //时间
      $('#created').val( moment().format("YYYY-MM-DDTHH:mm") );

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

      $("tbody").on("click", ".btn-edit", function() {
        $(".edit-box").show();      
        //发送请求渲染修改页面
        var id = $(this).parent().attr("data-id");
        $.ajax({
          url: "./posts/postsGetOne.php",
          data: {
            dataId: id
          },
          dataType: "json",
          success: function( info ) {
            console.log( info );
            //标题栏
            $("#title").val( info.title );
            //富文本编辑器
            editor.txt.html( info.content );
            $("#content").val( info.content );
            //slug栏
            $("#slug").val( info.slug );
            $("#strong").text( info.slug );
            //图像栏
            $("#img").attr("src", info.feature).show();
            // 发布时间
            $("#created").val(moment(info.created).format("YYYY-MM-DDTHH:mm"));
            //分类栏
            $("#category").val( info.category_id );
            //状态栏
            $("#status").val( info.status );
            //id
            $("#id").val( info.id );
          }
        })
     
      })

      //保存按钮
      $("#btn-update").on("click", function() {
        var formData = new FormData( $("#editForm")[0] );
        $.ajax({
          type: "post",
          url: "./posts/postsUpdate.php",
          data: formData,
          contentType: false,
          processData: false,
          success: function( info ) {
            render( currentPage );
            $(".edit-box").hide();
          }
        })
      })



      //取消按钮
      $("#btn-cancel").on("click", function() {
        $(".edit-box").hide();
      })


    })  
  </script>
  <script>NProgress.done()</script>
</body>
</html>
