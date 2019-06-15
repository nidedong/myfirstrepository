<?php
  include_once "../../fn.php";
  $page = $_GET['page'];
  $pageSize = $_GET['pageSize'];
  $strPage = ($page - 1) * $pageSize; 
  $sql = "select posts.*,users.nickname as author,
  categories.name as class from posts
  join users on users.id = posts.user_id 
  join categories on categories.id = posts.category_id
  order by id
  limit $strPage, $pageSize;";
  $data = my_query($sql);
  echo json_encode($data);
?>