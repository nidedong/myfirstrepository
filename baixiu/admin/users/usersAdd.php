<?php
  include_once "../../fn.php";
  $email = $_POST['email'];
  $slug = $_POST['slug'];
  $nickname = $_POST['nickname'];
  $pwd = $_POST['password'];
  $sql = "insert into users (email, slug, nickname, password)
  values ('$email', '$slug', '$nickname', '$pwd')";
  my_exec( $sql );
?>