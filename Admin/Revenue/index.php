<?php
  require_once('../../Database/config.php');
  session_start();
  if(!empty($_SESSION)){
    if(!isset($_SESSION['email'])){
      require_once('../NotFound/index.php');
      die();
    }else if($_SESSION['email'] !== "hieub1809236@student.ctu.edu.vn"){
      require_once('../NotFound/index.php');
      die();
    }
  }else{
      require_once('../NotFound/index.php');
      die();
  }
  $avt_sql = 'select Image from khachhang where Email = "hieub1809236@student.ctu.edu.vn"';
  $result = executeResultOne($avt_sql);
  $avt_url = $result['Image'];

  $sumDSql = 'SELECT SUM(a.GiaDatHang) as SumD FROM chitietdathang a, dathang b WHERE a.SoDonDH = b.SoDonDH and b.NgayGH = "'.date("Y-m-d").'" and b.trangthai = "Đã Giao"';
  $SumD = executeResultOne($sumDSql);
  if($SumD['SumD'] === NULL){
    $SumD['SumD'] = '0.0';
  }

  $sumMSql = 'SELECT SUM(a.GiaDatHang) as SumM FROM chitietdathang a, dathang b WHERE a.SoDonDH = b.SoDonDH and year(b.NgayGH) = "'.date("Y").'" and month(b.NgayGH) = "'.date("m").'" and b.trangthai = "Đã Giao"';
  $SumM = executeResultOne($sumMSql);
  if($SumM['SumM'] === NULL){
    $SumM['SumM'] = '0.0';
  }
  
  $sumYSql = 'SELECT SUM(a.GiaDatHang) as SumY FROM chitietdathang a, dathang b WHERE a.SoDonDH = b.SoDonDH and year(b.NgayGH) = "'.date("Y").'" and b.trangthai = "Đã Giao"';
  $SumY = executeResultOne($sumYSql);
  if($SumY['SumY'] === NULL){
    $SumY['SumY'] = '0.0';
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
    <link rel="stylesheet" href="../../font-awesome/fontawesome-free-5.15.3-web/css/all.min.css" />
    <title>Thống kê doanh thu</title>
    <style>
      .revender{
        margin-top: 15%;
        background: #fff;
        width: 1200px !important;
        border: 2px solid #dee2e6;
      }

      h4{
        color: #a19896;
      }

      .bg-icon{
        width: 64px;
        height: 64px;
        border-radius: 50%;
        position: relative;
      }

      .title{
        color: #afb2b5;
      }

      .price{
        font-size: 2.5rem;
        font-weight: bold;
        color: #495057;
      }

      .bg-icon i{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 140%;
      }

      .bg-orange{
        background: #f7b924;
      }

      .bg-pink{
        background: #d92550;
      }

      .bg-green{
        background: #3ac47d;
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
      <li class = "nav-item-home">
        <a href="/Resource/Admin"><span>💼</span>Quản lý Hàng Hóa</a>
      </li>
      <li>
        <a href="/Resource/Admin/Typeofgoods"><span>🎎</span>Quản lý Loại Hàng Hóa</a>
      </li>
      <li>
        <a href="/Resource/Admin/Order"><span>🛒</span>Quản lý Đặt Hàng</a>
      </li>
      <li>
        <a href="#"><span>💳</span>Thống kê Doanh Thu</a>
      </li>
    </ul>

    <div class="main">
      <ul class="nav justify-content-end nav-menu shadow-sm bg-body rounded">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">
            <img src="../../<?=$avt_url?>" alt="HN">
            <span><strong>Admin</strong></span>
          </a>
        </li>
      </ul>
      <div class="container revender">
        <h4 class="pt-3 p-0">Sales Performance</h4>
        <hr>
        <div class="row p-4 pt-2">
          <div class="col">
            <div class="d-flex align-items-center">
              <div class="bg-icon bg-orange">
                <i class="fas fa-laptop-house"></i>
              </div>
              <div class="infor ms-3">
                <div class="title">Current Day Revenue</div>
                <div class="price"><?=number_format((float)$SumD['SumD']/1000000, 1, '.', '');?>M</div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="d-flex align-items-center">
              <div class="bg-icon bg-pink">
              <i class="fab fa-bitcoin"></i>
              </div>
              <div class="infor ms-3">
                <div class="title">Current Month's Revenue</div>
                <div class="price text-danger"><?=number_format((float)$SumM['SumM']/1000000, 1, '.', '');?>M</div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="d-flex align-items-center">
              <div class="bg-icon bg-green">
              <i class="fas fa-coins"></i>
              </div>
              <div class="infor ms-3">
                <div class="title">Current Total Revenue</div>
                <div class="price text-success"><?=number_format((float)$SumY['SumY']/1000000, 1, '.', '');?>M</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  </body>
</html>
