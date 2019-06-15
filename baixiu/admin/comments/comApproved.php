<?php
  include_once "../../fn.php";
  $dataId = $_GET['dataId'];
  $sql = "update comments set status = 'approved' where id in ($dataId)";
  my_exec( $sql );
?>