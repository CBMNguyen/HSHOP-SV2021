 <?php
 session_start();
  require_once('../../../Database/config.php');
  function inform($title){
    return('
    <div class="alert alert-dark alert-dismissible fade show" role="alert">
      '.$title.'&nbsp
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
    ');
  }

  function checkValidate($email, $password){
    if(!empty($email)){
      $sql = 'select * from khachhang where khachhang.email = "'.$email.'"';
      $result = executeResultOne($sql);
      if(empty($result)){
        return inform('Email does not exists !');
      }
    }

    if(strlen($password) !== 8){
      return inform('Password must be 8 characters !');
    }

    if($result['PassWord'] !== $password){
      return inform('Wrong password !');
    }
    return true;
  }

  $email = $password = '';
 
  if(!empty($_POST)){
    
    if(isset($_POST['email'])){
      $email = $_POST['email'];
      $_SESSION['email'] = $email;
    }

    if(isset($_POST['password'])){
      $password = $_POST['password'];
      $_SESSION['password'] = $password;
    }
    
    if(checkValidate($email, $password) === true){
      header('location: /Resource');
      die();
    }else{
      echo checkValidate($email, $password);
    }
  }
  $password = '';
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
    <link rel="stylesheet" href="../../../main.css" />
    <link rel="stylesheet" href="./index.css" />
    <title>Login</title>
  </head>

  <body>
    <form method='POST'>
      <h2>Login</h2>
      <div class="input-group">
        <input type="email" id="email" name = "email" required value="<?=$email?>"/>
        <label for="email">Email</label>
      </div>

      <div class="input-group">
        <input type="password" id="password" name = "password" required/>
        <label for="password">Password</label>
      </div>
      <button type="submit">Login</button>
      <p>
        Don't have account?
        <a href="/Resource/components/Auth/SignUp/">Sign Up</a>
      </p>
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
