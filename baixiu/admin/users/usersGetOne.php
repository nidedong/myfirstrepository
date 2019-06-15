<?php
  include_once "../../fn.php";
  $id = $_GET['dataId'];
  $sql = "select * from users where id = $id";
  $data = my_query( $sql )[0];
  echo json_encode( $data );
?>