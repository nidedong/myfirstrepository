<?php
  include_once "../../fn.php";
  $id = $_GET['dataId'];
  $sql = "delete from categories where id = $id";
  my_exec( $sql );
  $sql = "select count(*) from categories";
  $data = my_query( $sql )[0];
  echo json_encode( $data );
?>