<?php
  include_once "../../fn.php";
  //获取基本信息
  $id = $_POST['id'];
  $title = $_POST['title'];
  $content = $_POST['content'];
  $slug = $_POST['slug'];
  $category = $_POST['category'];
  $created = $_POST['created'];
  $status = $_POST['status'];
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';
  //获取文件信息
  $file = $_FILES['feature'];
  if($file['error'] === 0) {
    $ext = strrchr($file['name'], '.');
    $newName = time() . rand(1000, 9999) . $ext;
    $tmp = $file['tmp_name'];
    $newFileUrl = "../../uploads/" . $newName;
    move_uploaded_file( $tmp, $newFileUrl );
    $feature = "../uploads/" . $newName;
  }

  //修改数据库中的数据
  if( empty($feature) ) {
    $sql = "update posts set title='$title', content='$content', 
    slug='$slug', category_id='$category', created='$created', status='$status'
    where id=$id";
  }else {
    $sql = "update posts set title='$title', content='$content', 
    slug='$slug', category_id='$category', created='$created', status='$status',
    feature='$feature' where id=$id";
  }
  my_exec( $sql );


?>