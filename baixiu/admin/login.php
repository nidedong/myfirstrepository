<?php
  if( !empty( $_POST ) ) {
    include_once "../fn.php";
    $email = $_POST['email'];
    $password = $_POST['password'];
    if( empty( $email ) || empty( $password ) ) {
      $msg = "请输入用户名或密码";
    }else {
      $sql = "select * from users where email = '$email'";
      $res = my_query( $sql );
      if( empty( $res ) ) {
        $msg = "用户名不存在";
      }else {
        $data = $res[0];
        if( $data['password'] === $password) {
          session_start();
          $_SESSION['user_id'] = $data['id'];
          header("location: index1.php");
        }else {
          $msg = "密码错误";
        }
      }
    
      // echo '<pre>';
      // print_r($res);
      // echo '</pre>';
    }
  }

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap" action="" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if(!empty($msg)) {?>
        <div class="alert alert-danger">
          <strong>错误！</strong> <?php echo $msg?>
        </div>
      <?php }?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" value="<?php if(isset($email)) {echo $email;}?>" type="text" class="form-control" placeholder="邮箱" autofocus name="email">
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码" name="password">
      </div>     
      <input  class="btn btn-primary btn-block" type="submit" value="登录">
    </form>
  </div>
</body>
</html>
