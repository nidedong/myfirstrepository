<?php
  //查询相应id的一条文章
  include_once "../../fn.php";
  $id = $_GET['dataId'];
  $sql = "select * from posts where id = $id";
  $data = my_query( $sql )[0];
  echo json_encode( $data );

?>