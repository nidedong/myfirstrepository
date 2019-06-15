<?php
  include_once "../../fn.php";
  $index = $_GET['index'];
  $sql = "select value from options where id=10";
  $data = my_query( $sql )[0]['value'];
  $arr = json_decode( $data, true );
  array_splice( $arr, $index, 1);
  $jsonStr = json_encode( $arr );
  $sql = "update options set value = '$jsonStr' where id=10";
  my_exec( $sql );
?>