<?php
  include_once "../../fn.php";
  $email = $_GET['email'];
  $slug = $_GET['slug'];
  $nickname = $_GET['nickname'];
  $pwd = $_GET['password'];
  $id = $_GET['id'];
  $sql = "update users set email='$email', slug='$slug', nickname='$nickname',
  password='$pwd' where id=$id";
  my_exec( $sql );
?>