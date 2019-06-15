<?php
  include_once "../../fn.php";
  echo '</pre>';
  $info['text'] = $_POST['text'];
  $info['link'] = $_POST['link'];

  $file = $_FILES['image'];
  if( $file['error'] === 0 ) {
    $ext = strrchr( $file['name'], '.' );
    $newName = time() . rand(1000, 9999) . $ext;
    $newFileUrl = "../../uploads/" . $newName;
    $tmp = $file['tmp_name'];
    move_uploaded_file( $tmp, $newFileUrl );
    $info['image'] = "../uploads/" . $newName;
  }
  $sql = "select value from options where id = 10";
  $data = my_query( $sql )[0]['value'];
  $arr = json_decode( $data, true );
  $arr[] = $info;
  $jsonStr = json_encode( $arr );
  $sql = "update options set value = '$jsonStr' where id=10";
  my_exec( $sql );

?>