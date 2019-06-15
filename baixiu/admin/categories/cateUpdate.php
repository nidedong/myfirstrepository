<?php
  include_once "../../fn.php";
  $id = $_GET['id'];
  $name = $_GET['name'];
  $slug = $_GET['slug'];
  $sql = "update categories set name='$name', slug='$slug' where id=$id";
  my_exec( $sql );
  

?>