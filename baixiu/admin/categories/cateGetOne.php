<?php
  include_once "../../fn.php";
  $id = $_GET['dataId'];
  $sql = "select * from categories where id = $id";
  $data = my_query( $sql )[0];
  echo json_encode( $data );

?>