<?php
  include_once "../../fn.php";
  $sql = "select * from users";
  $res = my_query( $sql );
  echo json_encode( $res );
?>