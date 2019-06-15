<?php
  include_once "../../fn.php";
  $pageSize = $_GET['pageSize'];
  $page = ( $_GET['page'] - 1 ) * $pageSize;
  $sql = "select comments.*,posts.title from comments join posts 
  on comments.post_id = posts.id limit $page, $pageSize";
  $data = my_query( $sql );
  echo json_encode( $data );
?>