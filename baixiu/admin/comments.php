<?php

include_once "../fn.php";
is_login();
$page = "comments";
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
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
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm btn-approveds">批量批准</button>
          <button class="btn btn-danger btn-sm btn-dels">批量删除</button>
        </div>
        <div class="page-box pull-right">

        </div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input class="th-ch" type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-info btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>

  <?php include_once "./inc/aside.php"?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script src="../assets/vendors/jquery-pagination/jquery.pagination.js"></script>
  <script id="tpl" type="text/html">
    {{ each list v i}}
    <tr>
      <td class="text-center"><input type="checkbox" class="tb-ch" data-id="{{ v.id }}"></td>
      <td>{{ v.author }}</td>
      <td>{{ v.content.substr(0, 30) }}...</td>
      <td>《{{ v.title }}》</td>
      <td>{{ v.created }}</td>
      <td>{{ state[v.status] }}</td>
      <td class="text-right" dataId="{{ v.id }}">
        {{ if v.status === 'held'}}
          <a href="javascript:;" class="btn btn-info btn-xs btn-approved">批准</a>
        {{ /if }}
        <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
      </td>
    </tr>
    {{ /each }}
  </script>
  <script>
    var currentPage = 0;
    $(function() {
      function render( page, pageSize ) {
        $.ajax({
          url: "./comments/comGet.php",
          dataType: "json",
          data: {
            page: page || 1,
            pageSize: pageSize || 10
          },
          success: function( info ) {
            var obj = {
              list: info,
              state: {
                held: "待审核",
                approved: "准许",
                rejected: "拒绝",
                trashed: "回收站"
              }
            }
            var htmlStr = template( "tpl", obj );
            $("tbody").html( htmlStr );
            $(".th-ch").prop("checked", false);
            $(".btn-batch").hide();
          }
        })
      }
      render();
      function setPage( curPage ) {
        $.ajax({
          url: "./comments/comTotal.php",
          dataType: "json",
          success: function( info ) {
            $( ".page-box" ).pagination( info.total, {
              prev_text: "« 上一页",
              next_text: "下一页 »",
              items_per_page:10,
              num_edge_entries: 1,       //两侧首尾分页条目数
              num_display_entries: 4,    //连续分页主体部分分页条目数
              current_page: curPage || 0,   //当前页索引
              callback: function( index) {
                currentPage = index + 1;
                render( index + 1);
              } //PageCallback() 为翻页调用次函数。
            });
          }
        })
      }
      setPage();
      //批准事件
      $( "tbody" ).on( "click", ".btn-approved", function() {
        $.ajax({
          data: {
            dataId: $( this ).parent().attr( "dataId" )
          },
          url: "./comments/comApproved.php",
          success: function( info ) {
            render( currentPage );
          }
        })
      } )
      //删除事件
      $( "tbody" ).on( "click", ".btn-del", function() {
        $.ajax({
          data: {
            dataId: $( this ).parent().attr( "dataId" )
          },
          dataType: "json",
          url: "./comments/comDelete.php",
          success: function( info ) {
            console.log( info.total );
            var maxPage = Math.ceil( info.total / 10 );
            currentPage = currentPage > maxPage ? maxPage : currentPage;
            render( currentPage );
            setPage( currentPage - 1);
          }
        })
      } )
      //全选
      $(".th-ch").on("click", function() {
        var flag = $( ".th-ch" ).prop( "checked" );
        if( flag ) {
          $(".btn-batch").show();
        }else {
          $(".btn-batch").hide();
        }
        $( ".tb-ch" ).prop( "checked", flag);


      })
      //多选
      $("tbody").on("click", ".tb-ch", function() {
        tbLength = $(".tb-ch").length;
        chLength = $(".tb-ch:checked").length;
        $(".th-ch").prop("checked", tbLength === chLength);
        if(chLength >= 2) {
          $(".btn-batch").show();
        }else {
          $(".btn-batch").hide();
        }
      })

      function getIds() {
        var arr=[];
        $(".tb-ch:checked").each(function() {
          var id = $(this).attr("data-id");
          arr.push(id);
        })
        return arr.join(",");
      }
      //批量批准
      $(".btn-approveds").on("click", function() {
        $.ajax({
          url: "./comments/comApproved.php",
          data: {
            dataId: getIds()
          },
          success: function(info) {
            render(currentPage);
            $(".btn-batch").hide();
            $(".th-ch").prop("checked", false);
          }
        })
      })
      //批量删除
      $(".btn-dels").on("click", function() {
        $.ajax({
          url: "./comments/comDelete.php",
          dataType: "json",
          data: {
            dataId: getIds()
          },
          success: function(info) {
            var maxPage = Math.ceil(info.total / 10);
            currentPage = currentPage > maxPage ? maxPage : currentPage;
            render(currentPage);
            setPage(currentPage - 1);
            $(".btn-batch").hide();
            $(".th-ch").prop("checked", false);
          }
        })
      })

    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
