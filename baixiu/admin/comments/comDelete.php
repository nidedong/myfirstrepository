<?php
  include_once "../../fn.php";
  $dataId = $_GET['dataId'];
  $sql = "delete from comments where id in ($dataId)";
  my_exec( $sql );
  $sql = "select count(*) as total from comments join posts on comments.post_id = posts.id";
  $res = my_query( $sql )[0];
  echo json_encode( $res );
?>