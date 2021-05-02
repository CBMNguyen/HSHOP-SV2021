<?php
  require_once('../../../Database/config.php');
  function inform($title){
    echo '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      '.$title.'
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
    ';
  }

  function checkValidate($email, $password, $rpassword, $name, $phone, $address){
 
    if(!is_numeric($phone) || (strlen(strval($phone)) !== 10)){
      return inform('Incorrect Telephone Number !');
    }

    if(!empty($email)){
      $sql = 'select * from khachhang where khachhang.email = "'.$email.'"';
      $result = executeResultOne($sql);
      if(!empty($result)){
        return inform('Email already exists !');
      }
    }

    if(strlen($password) !== 8){
      return inform('Password must be 8 characters !');
    }

    if($rpassword !== $password){
      return inform('Password is Incorrect !');
    }

    $sqlInsert = 'INSERT INTO khachhang VALUES ("", "'.$name.'", "", "'.$address.'", "'.$phone.'", "'.$email.'", "'.$password.'")';
    execute($sqlInsert);

    return true;
  }

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

    $count = 0;

    if(checkValidate($email, $password, $rpassword, $name, $phone, $address) === true){
      header('location: /Resource/components/Auth/SignIn');
      $count = 1;
    }else if($count === 1){
      echo checkValidate($email, $password, $rpassword, $name, $phone, $address);
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
    <link rel="stylesheet" href="./index.css" />
    <title>Sign Up</title>
  </head>

  <body>
    <form method="POST" >
      <h2>Sign Up</h2>
      <div class="input-group">
        <input type="text" id="name" name = "name" value = "<?=$name?>" required />
        <label for="name">Full Name</label>
      </div>

      <div class="input-group">
        <input type="tel" id="phone" name = "phone" value = "<?=$phone?>" required />
        <label for="phone">Phone</label>
      </div>

      <div class="input-group">
        <input type="text" id="address" name = "address" value = "<?=$address?>" required />
        <label for="address">Address</label>
      </div>

      <div class="input-group">
        <input type="email" id="email" name = "email" value = "<?=$email?>" required />
        <label for="email">Email</label>
      </div>

      <div class="input-group">
        <input type="password" id="password" name= "password" value = "<?=$password?>" required />
        <label for="password">Password</label>
      </div>

      <div class="input-group">
        <input type="password" id="rpassword" name = "rpassword" value = "<?=$rpassword?>" required />
        <label for="rpassword">Repeat Password</label>
      </div>
      <button type="submit">Sign Up</button>
    </form>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
      crossorigin="anonymous"
    ></script>
    <script>
      const alertElement = document.querySelector('.alert');
      
      const id = setTimeout(() => {
        alertElement.style.display = 'none';
      }, 2000);
      clearTimeOut(id);
    </script>
  </body>
</html>
