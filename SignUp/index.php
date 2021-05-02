<?php
  require_once('../Database/config.php');
  $checkEmailCustomer = [];
  $checkPassWord = '';
  $checkPhone = '';
  $email = $password = $rpassword = $name = $phone = $address = '';
  if(!empty($_POST)){
    if(isset($_POST['name'])){
      $name = $_POST['name'];
    }

    if(isset($_POST['phone'])){
      $phone = $_POST['phone'];
    }

    if(isset($_POST['address'])){
      $address = $_POST['address'];
    }

    if(isset($_POST['email'])){
      $email = $_POST['email'];
    }

    if(isset($_POST['password'])){
      $password = $_POST['password'];
    }

    if(isset($_POST['rpassword'])){
      $rpassword = $_POST['rpassword'];
    }
    $sqlCustomer = 'select * from khachhang where Email = "'.$email.'"';
    $checkEmailCustomer = executeResultOne($sqlCustomer);
    $sqlPhoneCustomer = 'select * from khachhang where SoDienThoai = "'.$phone.'"';
    $checkPhoneCustomer = executeResultOne($sqlPhoneCustomer);
    if(empty($checkEmailCustomer) && empty($checkPhoneCustomer) && $password === $rpassword){
      $sqlInsert = 'INSERT INTO khachhang VALUES ("", "'.$name.'", "", "'.$address.'", "'.$phone.'", "'.$email.'", "'.md5($password).'")';
      execute($sqlInsert);
      header('location: /Resource/SignIn');
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
    <link rel="stylesheet" href="../../main.css" />
    <link rel="stylesheet" href="./signup.css" />
    <link rel="stylesheet" href="../css/query.css" />
    <title>Sign Up</title>
  </head>

  <body>
    <form class="signup-form" method="POST">
      <h2>Sign Up</h2>
      <div class="input-group">
        <input type="text" id="phone" name = "name" value = "<?=$name?>" pattern = ".*" title="Tên không hợp lệ !" required />
        <label for="name">Full Name</label>
      </div>

      <div class="input-group">
        <?php
        if(empty($checkEmailCustomer)){
          echo '<input type="email" id="email" name = "email" required value="'.$email.'"/>';
        }else{
          echo '<input class="border-danger" type="email" id="email" name = "email" required value="'.$email.'"/>';
        }
        ?>
        <label for="email">Email</label>
      </div>

      <div class="input-group">
        <?php
          if(empty($checkPhoneCustomer) || !empty($checkEmailCustomer)){
            echo '<input type="tel" id="phone" name = "phone" value = "'.$phone.'" pattern = "0[0-9]{9}" title="Số điện thoại không hợp lệ !" required />';
          }else{
            echo '<input type="tel" id="phone" class="border-danger" name = "phone" pattern = "0[0-9]{9}" title="Số điện thoại không hợp lệ !" required />';
          }
        ?>
        <label for="phone">Phone</label>
      </div>

      <div class="input-group">
        <input type="text" id="address" name = "address" value = "<?=$address?>" pattern=".*" required />
        <label for="address">Address</label>
      </div>

      <div class="input-group">
          <input type="password" id="password" name = "password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Mật khẩu phải chứa 8 ký tự trở lên có ít nhất một số và một chữ hoa và chữ thường"  required
            value="<?=$password?>"
          /> 
          <label for="password">Password</label>
      </div>

      <div class="input-group">
        <?php
          if($password === $rpassword || !empty($checkPhoneCustomer)){
            echo '<input type="password" id="rpassword" name = "rpassword" value="'.$rpassword.'" required />';
          }else{
            echo '<input type="password" id="rpassword" class="border-danger" name = "rpassword" required />';
          }
        ?>
        <label for="rpassword">Repeat Password</label>
      </div>
      <button type="submit" class="mb-2">Sign Up</button>
      <?php 
        if(!empty($checkEmailCustomer)){
          echo '<span class="text-danger" d-inline-block mb-2"><sub>Email existed !</sub></span>';
        }else if(!empty($checkPhoneCustomer)){
          echo '<span class="text-danger" d-inline-block mb-2"><sub>Phone existed !</sub></span>';
        }else if($password !== $rpassword){
          echo '<span class="text-danger" d-inline-block mb-2"><sub>Password does not exact !</sub></span>';
        }
      ?>
    </form>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
      crossorigin="anonymous"
    ></script> 
  </body>
</html>
