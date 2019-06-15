<?php
  include_once "../../fn.php";
  $sql = "select * from categories order by id desc";
  $data = my_query( $sql );
  echo json_encode( $data );
?>