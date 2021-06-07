<?php
  require_once('../../Database/config.php');
  session_start();
  if(!empty($_SESSION)){
    if($_SESSION['email']!== "hieub1809236@student.ctu.edu.vn"){
      require_once('../../NotFound/index.php');
      die();
    }
  }else{
    require_once('../../NotFound/index.php');
      die();
  }
  $name = $position = $address = $phone = $salary = $oldPhone = $email = '';
  if(empty($_GET)){
    if(!empty($_POST)){
      if(isset($_POST['name'])){
        $name = str_replace('"','\\"',$_POST['name']);
      }
      if(isset($_POST['position'])){
        $position = str_replace('"','\\"',$_POST['position']);
      }
      if(isset($_POST['address'])){
        $address = str_replace('"','\\"',$_POST['address']);
      }
      if(isset($_POST['phone'])){
        $phone = str_replace('"','\\"',$_POST['phone']);
      }
      if(isset($_POST['email'])){
        $email = str_replace('"','\\"',$_POST['email']);
      }
      if(isset($_POST['salary'])){
        $salary = str_replace('"','\\"',$_POST['salary']);
      }

      $oldPhoneSql = 'select * from nhanvien where SoDienThoai = "'.$phone.'"';
      $oldPhone = executeResultOne($oldPhoneSql);

      $oldEmailSql = 'select * from nhanvien where Email = "'.$email.'"';
      $oldEmail = executeResultOne($oldEmailSql);

      if(empty($oldPhone) && empty($oldEmail)){
        $sql = 'insert into nhanvien values ("", "'.$name.'", "'.$position.'", "'.$address.'", "'.$phone.'" ,"'.$salary.'", "'.$email.'")';
        execute($sql);
        header('location: /Resource/Admin/Employees');
        die();
      }else{
        $_GET['MSNV'] = NULL;
        // $oldEmail['MSNV']=NULL;
      }
    }
  }else{
    $checkSql = 'select * from nhanvien where MSNV = "'.$_GET['MSNV'].'"';
    $isEmployed = executeResultOne($checkSql);
    
    if(empty($isEmployed)){
      require_once('../../NotFound/index.php');
      die();
    }else{
      $name = $isEmployed['HoTenNV'];
      $position = $isEmployed['ChucVu'];
      $address = $isEmployed['DiaChi'];
      $email = $isEmployed['Email'];
      $phone = $isEmployed['SoDienThoai'];
      $salary = $isEmployed['Luong'];
      if(!empty($_POST)){
        if(isset($_POST['name'])){
          $newName = str_replace('"','\\"',$_POST['name']);
        }
        if(isset($_POST['position'])){
          $newPosition = str_replace('"','\\"',$_POST['position']);
        }
        if(isset($_POST['address'])){
          $newAddress = str_replace('"','\\"',$_POST['address']);
        }
        if(isset($_POST['phone'])){
          $newPhone = str_replace('"','\\"',$_POST['phone']);
        }
        if(isset($_POST['email'])){
          $newEmail = str_replace('"','\\"',$_POST['email']);
        }
        if(isset($_POST['salary'])){
          $newSalary = str_replace('"','\\"',$_POST['salary']);
        }
        $yourphoneSql = 'select * from nhanvien where SoDienThoai = "'.$newPhone.'" and MSNV = "'.$_GET['MSNV'].'"';
        $yourPhone = executeResultOne($yourphoneSql); 

        $oldPhoneSql = 'select * from nhanvien where SoDienThoai = "'.$newPhone.'"';
        $oldPhone = executeResultOne($oldPhoneSql);
        
        $youremailSql = 'select * from nhanvien where Email = "'.$newEmail.'" and MSNV = "'.$_GET['MSNV'].'"';
        $yourEmail = executeResultOne($youremailSql); 

        $oldEmailSql = 'select * from nhanvien where Email = "'.$newEmail.'"';
        $oldEmail = executeResultOne($oldEmailSql);
        if(empty($oldPhone) || !empty($yourPhone)){

          if((empty($oldEmail) || !empty($yourEmail))){
            $sql = 'update nhanvien set HoTenNV = "'.$newName.'", ChucVu="'.$newPosition.'", 
            DiaChi="'.$newAddress.'", SoDienThoai="'.$newPhone.'",Luong="'.$newSalary.'",
            Email="'.$newEmail.'" 
            where MSNV = "'.$isEmployed['MSNV'].'"';
            execute($sql);
            header('location: /Resource/Admin/Employees');
            die();
          }
        }
      }
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Website bán iphone và macbook uy tín chất lượng cao"
    />
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
    
    <link rel="stylesheet" href="./indexx.css" />
    <link rel="stylesheet" href="../../css/query.css" />
    <title>
      <?php 
              if(!empty($isEmployed)){
                echo  '
                  Cập nhật nhân viên
                ';
              }else{
                echo '
                  Thêm hàng nhân viên
                ';
              }
      ?>
    </title>
  </head>
  <body>
    <ul class="nav-col nav nav-tabs shadow-sm bg-body rounded">
      <li class="nav-item">
        <img
          src="https://colorlib.com/polygon/adminator/assets/static/images/logo.png"
          alt="logo"
        />
        <span>Adminator</span>
      </li>
      <li>
        <a href="/Resource/Admin"><span>🏠</span>Home</a>
      </li>
      <li class = "nav-item-home">
        <a href="/Resource/Admin/Employees"><span>👨‍✈️</span>Quản lý Nhân Viên</a>
      </li>
      <li >
        <a href="/Resource/Admin/Customers"><span>🙎‍♂️</span>Quản lý Khách Hàng</a>
      </li>
      <li>
        <a href="/Resource/Admin"><span>💼</span>Quản lý Hàng Hóa</a>
      </li>
      <li>
        <a href="/Resource/Admin/Typeofgoods"><span>🎎</span>Quản lý Loại Hàng Hóa</a>
      </li>
      <li>
        <a href="/Resource/Admin/Carts"><span>🛒</span>Quản lý Giỏ Hàng</a>
      </li>
      <li>
        <a href="/Resource/Admin/Revenue"><span>💳</span>Thống kê Doanh Thu</a>
      </li>
    </ul>

    <div class="main">
      <ul class="nav justify-content-end nav-menu shadow-sm bg-body rounded">
      <form class="d-flex me-auto">
        <input class="form-control me-2" type="search" placeholder="Tìm kiếm hàng hóa" aria-label="Search">
        <button class="btn search-btn" type="submit">Search</button>
      </form>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">
            <img src="../../img/avt.jpg" alt="HN">
            <span>Admin</span>
          </a>
        </li>
      </ul>

      <div class="container">
      <div class="row mt-3 w-50 m-auto">
          <div class="col"><h3 class="bg-info text-light text-center p-2">Thông tin nhân viên</h3></div>
      </div>
      <form class="container-fluid shadow p-3 mt-3 bg-body rounded w-50" method="POST">
        <div class="mb-2">
          <label for="name" class="form-label">Họ và Tên</label>
          <input type="text" class="form-control" id="name" name="name" value = "<?=$name?>" required>
        </div>
        <div class="mb-2">
          <label for="position" class="form-label">Chức vụ</label>
          <input type="text" class="form-control" id="position" name="position" value = "<?=$position?>" required>
        </div>
        <div class="mb-2">
          <label for="address" class="form-label">Địa chỉ</label>
          <input type="text" class="form-control" id="address" name="address" value = "<?=$address?>" required>
        </div>
        <div class="mb-2">
          <label for="phone" class="form-label">Số điện thoại</label>
          <?php
            if(empty($oldPhone) || $oldPhone['MSNV'] === $_GET['MSNV']){
              echo '<input type="tel" class="form-control" id="phone" pattern="0[0-9]{9}" name="phone" value = "'.$phone.'" required>';
            }else{
              echo '<input type="tel" class="form-control outline-phone" id="phone" pattern="0[0-9]{9}" name="phone" placeholder = "Số điện thoại đã tồn tại" required>';
            }
          ?>
        </div>
        <div class="mb-2">
          <label for="email" class="form-label">Email</label>
          <?php
            if(empty($oldEmail) || $oldEmail['MSNV'] === $_GET['MSNV']){
              echo '<input type="email" class="form-control" id="email" name="email" value = "'.$email.'" required>';
            }else{
              echo '<input type="email" class="form-control outline-phone" id="email" name="email" placeholder="Email đã tồn tại" required>';
            }
          ?>
        </div>
        <div class="mb-2">
          <label for="salary" class="form-label">Lương</label>
          <input type="number" class="form-control" id="salary" name="salary" min="0" max="50000000" value = "<?=$salary?>" required>
        </div>
        <button type="submit" class="btn btn-info w-75 mt-4 d-block m-auto text-light">
              <?php 
                if(empty($isEmployed)){
                  echo 'Thêm nhân viên';
                }else{
                  echo 'Cập nhật nhân viên';
                }
              ?>
        </button>
      </form>
      </div>
    </div>
  </body>
</html>
