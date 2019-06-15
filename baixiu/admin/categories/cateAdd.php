<?php
  include_once "../../fn.php";
  $name = $_GET['name'];
  $slug = $_GET['slug'];
  $sql = "insert into categories (slug, name) values ('$slug', '$name')";
  my_exec( $sql );

?>