<?php
  header('content-type:text/html;charset=utf-8');
  define( "HOST", "127.0.0.1" );
  define( "UNAME", "root" );
  define( "PSW", "root" );
  define( "DB", "z_baixiu" );
  define( "PORT", "3306" );
  //非查询语句
  function my_exec( $sql ) {
    $link = mysqli_connect( HOST, UNAME, PSW, DB, PORT);
    if(!$link) {//链接数据库失败
      echo "连接数据库错误";
      return false;
    }
    $res = mysqli_query( $link, $sql );
    if(!$res) {//执行sql语句失败
      echo mysqli_error( $link );
      mysqli_close( $link );
      return false;
    }
    //执行语句成功
    mysqli_close( $link );
    return true;
  }

  //查询语句
  function my_query( $sql ) {
    $link = mysqli_connect( HOST, UNAME, PSW, DB, PORT);
    if( !$link ) {
      echo "数据库连接错误";
      return false;
    }
    $res = mysqli_query( $link, $sql);
    if( !$res ) {
      echo mysqli_error( $link );
      mysqli_close( $link );
      return false;
    }
    $arr = [];
    while( $row = mysqli_fetch_assoc( $res ) ) {
      $arr[] = $row;
    }
    mysqli_close( $link );
    return $arr;
  }

  //登陆拦截
  function is_login() {
    if( isset( $_COOKIE['PHPSESSID'] ) ) {
      session_start();
      if( isset($_SESSION['user_id'] ) ) {
      }else {
        header("location: login.php");
      }
    }else {
      header("location: login.php");
    }
  }
?>