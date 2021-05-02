 <?php
  session_start();
  require_once('../Database/config.php');
  $email = $password = $checkPassWord = '';
  $checkEmailCustomer = [NULL];
  $location = '/Resource';

  if(!empty($_GET)){
    if(isset($_GET['previous'])){
      $location = '/Resource/infor.php?code='.$_GET['previous'];
    }
  }

  if(!empty($_POST)){
    
    if(isset($_POST['email'])){
      $email = $_POST['email'];
      
    }

    if(isset($_POST['password'])){
      $password = $_POST['password'];
    }

    $sqlCustomer = 'select * from khachhang where Email = "'.$email.'"';
    $checkEmailCustomer = executeResultOne($sqlCustomer);
    if(!empty($checkEmailCustomer)){
      $checkPassWord = $checkEmailCustomer['PassWord'];
    }
    
    if(!empty($checkEmailCustomer) && (md5($password) === $checkPassWord)){
      $_SESSION['email'] = $email;
      header('location: '.$location.'');
      die();
    }
  }
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="\Resource\favicon/apple-touch-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="\Resource\favicon/favicon-32x32.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="\Resource\favicon/favicon-16x16.png"
    />
    <link rel="manifest" href="\Resource\favicon/site.webmanifest" />
    <link rel="shortcut icon" href="\Resource\favicon/favicon.ico" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta
      name="msapplication-config"
      content="\Resource\favicon/browserconfig.xml"
    />
    <meta name="theme-color" content="#ffffff" />

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../main.css" />
    <link rel="stylesheet" href="./index.css" />
    <title>Login</title>
  </head>

  <body>
    <form method='POST'>
      <h2>Login</h2>
      <div class="input-group">
        <?php
        if(!empty($checkEmailCustomer)){
          echo '<input type="email" id="email" name = "email" required value="'.$email.'"/>';
        }else{
          echo '<input class="border-danger" type="email" id="email" name = "email" required value="'.$email.'"/>';
        }
        ?>
        <label for="email">Email</label>
      </div>

      <div class="input-group">
      <?php
        if(!empty($checkEmailCustomer) &&  $password !== $checkPassWord){
          echo '<input type="password" id="password" class="border-danger" name = "password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
          title="Mật khẩu phải chứa 8 ký tự trở lên có ít nhất một số và một chữ hoa và chữ thường"  required/>';
        }else{
          echo '<input type="password" id="password" name = "password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
          title="Mật khẩu phải chứa 8 ký tự trở lên có ít nhất một số và một chữ hoa và chữ thường"  required/>';
        }
        ?>
        <label for="password">Password</label>
      </div>
      <button type="submit" class="mb-2">Login</button>
      <?php 
        if(empty($checkEmailCustomer)){
          echo '<span class="text-danger d-inline-block mb-2"><sub>Email does not exist !</sub></span>';
        }else if($password !== $checkPassWord){
          echo '<span class="text-danger d-inline-block mb-2"><sub>Wrong password !</sub></span>';
        }
      ?>
      <p>
        Don't have account?
        <a href="../SignUp">Sign Up</a>
      </p>
    </form>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
