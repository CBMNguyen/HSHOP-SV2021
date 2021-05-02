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
  $name = '';
  if(!empty($_POST) && !isset($_GET['type'])){
    $productSql = 'select * from loaihanghoa where TenLoaiHang = "'.$_POST['name'].'"';
    $productName = executeResultOne($productSql);
    if(empty($productName)){
      if(isset($_POST['name'])){
        $name = $_POST['name'];
      }
      $sql = 'insert into loaihanghoa values("", "'.$name.'", "'.date("Y-m-d").'", "'.date("Y-m-d").'")';
      execute($sql);
      header('location: /Resource/Admin/Typeofgoods');
      die();
    }
  }
  
  if(!empty($_GET)){
    if(isset($_GET['type'])){
      $typeSql = 'select * from loaihanghoa where MaLoaiHang = "'.$_GET['type'].'"';
      $typeProduct = executeResultOne($typeSql);
      if(!empty($typeProduct)){
        $name = $typeProduct['TenLoaiHang'];
        if(!empty($_POST)){
          $productSql = 'select * from loaihanghoa where TenLoaiHang = "'.$_POST['name'].'"';
          $productName = executeResultOne($productSql);
          if(empty($productName)){
            if(isset($_POST['name'])){
              $name = $_POST['name'];
            }
            $sql = 'update loaihanghoa set TenLoaiHang = "'.$name.'", Created_at = "'.$typeProduct['Created_at'].'", 
            Updated_at = "'.date("Y-m-d").'"
            where MaLoaiHang = "'.$_GET['type'].'"
            ';
            execute($sql);
            header('location: /Resource/Admin/Typeofgoods');
            die();
          }
        }
      }else{
        require_once('../../NotFound/index.php');
        die();
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
    
    <link rel="stylesheet" href="./index.css" />
    <link rel="stylesheet" href="../../css/query.css" />
    <title>
      <?php
        if(empty($_GET['type'])){
          echo 'Thêm loại hàng hóa';
        }else{
          echo 'Cập nhật loại hàng hóa';
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
      <li>
        <a href="/Resource/Admin/Employees"><span>👨‍✈️</span>Quản lý Nhân Viên</a>
      </li>
      <li>
        <a href="/Resource/Admin/Customers"><span>🙎‍♂️</span>Quản lý Khách Hàng</a>
      </li>
      <li>
        <a href="/Resource/Admin"><span>💼</span>Quản lý Hàng Hóa</a>
      </li>
      <li class = "nav-item-home">
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
          <div class="col"><h3 class="bg-info text-light text-center p-2">Thông Tin loại hàng</h3></div>
      </div>
      <form class="container-fluid shadow p-3 mt-3 bg-body rounded w-50" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Tên hàng hóa</label>
          <?php 
            if(empty($productName)){
              echo '<input type="text" class="form-control" id="name" name="name" value = "'.$name.'" required>';
            }else{
              echo '<input type="text" class="form-control border-danger" id="name" name="name" placeholder="Tên hàng hóa đã tồn tại" required>';
            }
          ?>
        </div>
        <button type="submit" class="btn btn-info w-75 d-block m-auto mt-3 text-light">
            <?php
            if(empty($_GET['type'])){
              echo 'Thêm loại hàng hóa';
            }else{
              echo 'Cập nhật loại hàng';
            }
          ?>
        </button>
      </form>
      </div>
    </div>
  </body>
</html>
