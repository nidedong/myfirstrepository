<?php
  include_once "../../fn.php";
  //获取基本信息
  $slug = $_POST['slug'];
  $title = $_POST['title'];
  $created = $_POST['created'];
  $content = $_POST['content'];
  $status = $_POST['status'];
  session_start();
  $user_id = $_SESSION['user_id'];
  $category_id = $_POST['category'];

  //获取文件信息
  $file = $_FILES['feature'];
  $ext = strrchr($file['name'], ".");
  $newName = time() . rand(1000, 9999) . $ext;
  echo $newName;
  $tmp = $file['tmp_name'];
  $newFileUrl = "../../uploads/" . $newName;
  move_uploaded_file( $tmp, $newFileUrl );
  $feature = "../uploads/" . $newName;

  //将信息存入数据库中
  $sql = "insert into posts (slug, title, feature,
   created, content, status, user_id, category_id)
  values('$slug', '$title', '$feature', '$created', 
  '$content', '$status', '$user_id', '$category_id')";
  my_exec( $sql );
  header("location: ../posts.php");

?>