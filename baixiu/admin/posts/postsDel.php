<?php
  include_once "../../fn.php";
  $id = $_GET['dataId'];
  $sql = "delete from posts where id in ($id)";
  my_exec($sql);
  $sql = "select count(*) as total from posts
  join users on users.id = posts.user_id 
  join categories on categories.id = posts.category_id";
  $data = my_query($sql)[0];
  echo json_encode($data);
?>