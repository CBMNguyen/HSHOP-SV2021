<?php
  require_once('../../Database/config.php');
  session_start();
  if(!empty($_SESSION)){
    if(!isset($_SESSION['email'])){
      require_once('../../NotFound/index.php');
      die();
    }else if($_SESSION['email'] !== "hieub1809236@student.ctu.edu.vn"){
      require_once('../../NotFound/index.php');
      die();
    }
  }else{
      require_once('../../NotFound/index.php');
      die();
  }
  $sql = 'select * from dathang';
  $orderId = executeResult($sql);

  if(!empty($_POST)){
    if(isset($_POST['data'])){
      $updateSql = 'update dathang set trangthai = "Đã xác nhận" where SoDonDH = "'.$_POST['data'].'"';
      execute($updateSql);
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
    <link rel="stylesheet" href="../index.css" />
    <title>Quản Lý Hóa đơn</title>
    <style>
      .state{
        right: 0%;
        top: 0;
      }
    </style>
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
      <li >
        <a href="/Resource/Admin/Customers"><span>🙎‍♂️</span>Quản lý Khách Hàng</a>
      </li>
      <li>
        <a href="/Resource/Admin/"><span>💼</span>Quản lý Hàng Hóa</a>
      </li>
      <li>
        <a href="/Resource/Admin/Typeofgoods"><span>🎎</span>Quản lý Loại Hàng Hóa</a>
      </li>
      <li class = "nav-item-home">
        <a href="#"><span>🛒</span>Quản lý Đặt Hàng</a>
      </li>
      <li>
        <a href="/Resource/Admin/Revenue"><span>💳</span>Thống kê Doanh Thu</a>
      </li>
    </ul>

    <div class="main">
      <ul class="nav justify-content-end nav-menu shadow-sm bg-body rounded">
      <form class="d-flex me-auto">
        <input id="myInput" onkeyup="searchPhone()" class="form-control me-2" type="search" 
          placeholder="Nhập tên hàng hóa " 
          aria-label="Search">
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
      <section class="order">
     <div class="container">
     <div class="mt-3">
          <?php
            if(!empty($orderId)){
              foreach($orderId as $order){
                $sumMoney = 0;
                $orderDetailSql = 'select * from chitietdathang where SoDonDH = "'.$order['SoDonDH'].'"';
                $orderDetail = executeResult($orderDetailSql);
                $userSql = 'select * from khachhang where MSKH = "'.$order['MSKH'].'"';
                $User = executeResultOne($userSql);

                $stateColor = "text-secondary";
                if($order['trangthai'] === 'Đã xác nhận'){
                  $stateColor = "text-danger";
                }else if($order['trangthai'] === 'Đã giao'){
                  $stateColor = "text-success";
                }

                $confirmBtn = '<a onclick="Confirm('.$order['SoDonDH'].')" class = "btn btn-sm btn-warning d-inline-block text-white">Xác nhận</a>';
                if($order['trangthai'] === "Đã xác nhận" || $order['trangthai'] === "Đã giao"){
                  $confirmBtn = null;
                }
                echo '
                <ul class="list-group list-group-flush w-100 m-0 mb-2 bill shadow p-1 bg-info rounded">
                  <li class="list-group-item position-relative">
                    <div class="fw-bold w-75 d-flex justify-content-between">
                      ID: '.$order['SoDonDH'].'
                      <div>'.$User['HoTenKH'].'</div>
                      <div>'.$User['Email'].'</div>
                      <div>'.$User['SoDienThoai'].'</div>
                      <div>'.$User['DiaChi'].'</div>
                      <div class="position-absolute state p-1 pe-2 '.$stateColor.' ">'.$order['trangthai'].'</div>
                    </div>
                  </li>';
                foreach($orderDetail as $product){
                  $sql = 'select TenHH from hanghoa where MSHH = "'.$product['MSHH'].'"';
                  $item = executeResultOne($sql);
                  $sumMoney += (int)$product['SoLuong'] * (int)$product['GiaDatHang'];
                  echo '
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Tên sản phẩm: '.$item['TenHH'].'</span> 
                    <span class="position-absolute" style="left:50%" >Số lượng: '.$product['SoLuong'].'</span>
                    <span>Giá trị: '.number_format((int)$product['SoLuong'] * (int)$product['GiaDatHang'], 0, '.', '.').'<span></li>
                    ';
                }
                  echo '
                    <li class="list-group-item d-flex justify-content-between">
                      <span>Ngày đặt hàng: '.$order['NgayDH'].'</span>
                      <span>Ngày giao hàng: '.$order['NgayGH'].'</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <span>Tổng số tiền: <strong class="text-danger">'.number_format($sumMoney, 0, '.', '.').'</strong><sup class="text-danger">đ</sup></span> 
                      '.$confirmBtn.'
                    </li>
                  </ul>
                    ';
              }
            }else{
              echo '<li class="list-group-item text-center">Bạn chưa có đơn đặt hàng nào (☞ﾟヮﾟ)☞</li>';
            }
          ?>
     </div>
     </div>
    </section>
      </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
       function Confirm(id){
        option = confirm("Xác nhận đơn hàng ?");
        if(!option){
          return;
        }

        $.post("/Resource/Admin/Order/index.php", {
          "data": id,
        }, (data)=>{
          location.reload();
        })
      }
    </script>
  </body>
</html>
