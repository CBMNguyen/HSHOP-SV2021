<?php
  session_start();
  require_once('../Database/config.php');
  $sumMoney = 0;
  $orderDetail = [];
  if(!empty($_SESSION)){
    if(isset($_SESSION['email']) && isset($_SESSION['product'])){
      $userSql = 'select * from khachhang where Email = "'.$_SESSION['email'].'"';
      $User = executeResultOne($userSql);
      $userAddressSql = 'select DiaChi from diachikh where MSKH = "'.$User['MSKH'].'"';
      $userAddress = executeResultOne($userAddressSql);
      $findOrderSql = 'select * from dathang where MSKH = "'.$User['MSKH'].'" and trangthai != "Đã Giao"';
      $orderId = executeResult($findOrderSql);
    }
  }

  if(!empty($_POST)){
    if(isset($_POST['data'])){
      $updateSql = 'update dathang set trangthai = "Đã giao", NgayGH = "'.date("Y-m-d").'" where SoDonDH = "'.$_POST['data'].'"';
      execute($updateSql);
    }
  }

  if(!empty($_POST)){
    if(isset($_POST['data'])){
     if($_POST['data']==="all"){
      //  $_SESSION['productFilter'] = "";
     }else{
      //  $_SESSION['productFilter'] = " and left(MSHH,4) = ".$_POST['data'];
     }
    }else if(isset($_POST['amount'])){
      // $_SESSION['amount'] = $_SESSION['amount'] + 1;
    }else if(isset($_POST['isNightMode'])){
     if(isset($_POST['isNightMode'])){
       $_SESSION['isNightMode'] = $_POST['isNightMode'];
     }else{
       $_SESSION['isNightMode'] = 0;
     }
    }
   }else{
     if(!isset($_SESSION['productFilter'])){
      //  $_SESSION['productFilter'] = '';
     }
 
     if(!isset($_SESSION['amount'])){
      //  $_SESSION['amount'] = 1;
     }
     if(!isset($_SESSION['isNightMode'])){
       $_SESSION['isNightMode'] = 0;
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
    <link
      rel="manifest"
      href="\Resource\favicon/site.webmanifest"
    />
    <link
      rel="shortcut icon"
      href="\Resource\favicon/favicon.ico"
    />
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
    <link rel="stylesheet" href="./main.css" />
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/query.css" />
    <link
      href="../font-awesome/fontawesome-free-5.15.3-web/css/all.min.css"
      rel="stylesheet"
    />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    <link rel="stylesheet" href="../main.css" />
    <title>Đơn hàng của bạn</title>
    <style>
       <?php
        if($_SESSION['isNightMode'] === "1"){
          echo '
            body, .information, .address, .copy-right, .row{
              background-color: black !important;
            }

            footer ul li:hover{
              color: rgb(240, 219, 28);
            }

            .row{
              color: white !important;
            }

            .information, .address, .copy-right{
              color: white !important;
            }
          ';
        }
      ?>

      .close{
        right: 0;
        top: -3%;
        transition: all 0.25s ease-in-out 0s;
      }

      .close:hover{
        transform: scale(1.1);
        cursor: pointer;
      }

      .nav-login h6{
        font-size: 18px;
      }

      .infor li:first-child{
        background-color: #0dcaf0;
      }

      .infor li{
        color: black;
        background-color: rgb(247, 247, 247);
        font-weight: 400;
      }

    </style>
  </head>
  <body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container">
            <a class="navbar-brand" href="/Resource"
              ><img src="../img/logo1.png" alt="l0go1" width="50px" height="50px"
            /></a>
            <a class="navbar-brand me-5 pt-3 text-light" href="/Resource"><h5>H✨APPLE</h5></a>
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <form class="d-flex nav-form m-auto w-50">
                <input
                  class="form-control me-2"
                  type="search"
                  placeholder="Hãy tìm sản phẩm yêu thích của bạn ... 🛒"
                  aria-label="Search"
                />
                <button type="submit"><i class="fas fa-search fa-lg"></i></button>
              </form>
              <ul class="navbar-nav me-0 mb-2 mb-lg-0">
                <li class="nav-item me-5 position-relative cart">
                  <a
                      class="nav-link nav-cart active mt-2"
                      aria-current="page"
                      href="#"
                      ><div>
                        <span>Giỏ hàng</span>
                        <?php
                          $animate = ''; 
                          if(!empty($_SESSION)){
                            if(isset($_SESSION['product'])){
                              if(count($_SESSION['product'])!==0){
                                $animate = "animate__animated animate__tada animate__delay-1s 	animate__repeat-3";
                              }
                            }
                          }
                        ?>
                        <i class="fas fa-cart-plus fa-lg <?=$animate?>"
                          ><span class="badge bg-danger">
                          <?php
                            if(!empty($_SESSION)){
                              if(isset($_SESSION['product'])){
                                echo ''.count($_SESSION['product']).'';
                              }
                            }else{
                              echo '0';
                            }
                          ?>
                          </span></i
                        >
                      </div>
                    </a>
                    <div class="showCart shadow p-1 mb-5 bg-body rounded">
                      <?php
                        if(!empty($_SESSION)){
                          if(isset($_SESSION['product'])){
                            $index = 0;
                            $money = 0;
                            $MSHH = '';
                            foreach($_SESSION['product'] as $item){
                              $sql = 'select * from hanghoa where MSHH = "'.$_SESSION['product'][$index][0].'"';
                              $currentProduct = executeResultOne($sql);
                              $option = "Rom: ".$currentProduct['Rom'];
                              $MSHH = $currentProduct['MSHH'];
                              if($currentProduct['MaLoaiHang'] === "2"){
                                $option = "Ssd: ".$currentProduct['Ssd'];
                              }
                              echo '
                                <div class="d-flex align-items-center mb-2 product-item pb-2">
                                  <a href="/Resource/infor.php?code='.$currentProduct['MSHH'].'" class="text-decoration-none text-dark">
                                    <img class="p-2" src="../'.$currentProduct['thumbnail'].'" alt="#" width="60px" height="60px">
                                  </a>
                                  <div class="flex-grow-1">
                                    <a href="/Resource/infor.php?code='.$currentProduct['MSHH'].'" class="text-decoration-none text-dark">
                                      <h6 class="p-0 m-0">'.$currentProduct['TenHH'].'</h6>
                                      <div>Ram: '.$currentProduct['Ram'].' &nbsp;&nbsp;&nbsp;&nbsp;'.$option.'</div>
                                      <div>Số lượng: '.$_SESSION['product'][$index][1].' &nbsp;&nbsp;Giá: '.number_format($_SESSION['product'][$index][1]*$currentProduct['GiamGia'], 0, '.', '.').'</div>
                                    </a>
                                  </div>
                                  <div onclick="delProduct(this.id)" id='.$currentProduct['MSHH'].' class="ps-2 pe-2 close"><i class="fas fa-times fa-lg"></i></div>
                                </div>
                              ';
                              $money += $currentProduct['GiamGia']*$_SESSION['product'][$index][1];
                              $index++;
                            }
                            if(count($_SESSION['product']) !== 0){
                              $function = "onclick=orderProduct("."'$MSHH'".")";
                              echo '
                                <div>
                                <div class="d-flex align-items-center justify-content-between p-2">
                                  <h6 class="p-0 m-0">Tổng số tiền: <span class="text-danger">'.number_format($money, 0, '.', '.').'<sup>đ</sup></span></h6>
                                  <a '.$function.' class="btn btn-warning text-light">Mua Ngay</a>
                                </div>
                              </div>
                            ';
                            }else{
                              echo '
                                <div class="d-flex align-items-center product-item">
                                <div class="text-success m-auto p-0 m-0">🎉Giỏ hàng rỗng...🎉</div> 
                                </div>
                              ';
                            }
                          }
                        }else{
                          echo '
                            <div class="d-flex align-items-center mb-2 product-item pb-2">
                            <div class="text-success m-auto">🎉Giỏ hàng rỗng...🎉</div> 
                            </div>
                          ';
                        }
                      ?>
                    </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle active mt-2 nav-login" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php
                   $mode = '<li><a class="dropdown-item text-dark" onclick="isNightMode()"><i class="fas fa-moon"></i> Night Mode</a></li>';
                    if(!isset($_SESSION['email'])){
                      if($_SESSION['isNightMode'] === "1"){
                        $mode = '<li><a class="dropdown-item text-dark" onclick="isLightMode()"><i class="fas fa-sun"></i> Light Mode</a></li>';
                      }
                      echo '
                        <h6 class="text-light d-inline-block">💇‍♂️ Customers</h6></a>
                        <ul class="dropdown-menu w-25 position-absolute p-0 m-0" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item text-dark" href="/Resource/SignIn"><i class="fas fa-sign-in-alt"></i> Sign In</a></li>
                        '.$mode.'
                      </ul>
                      ';
                    }else{
                      $sql = 'select MSKH, Image from khachhang where Email = "'.$_SESSION['email'].'"';
                      $current_User = executeResultOne($sql);

                      if($_SESSION['isNightMode'] === "1"){
                        $mode = '<li><a class="dropdown-item text-dark" onclick="isLightMode()"><i class="fas fa-sun"></i> Light Mode</a></li>';
                      }
                      echo '
                      <img class="rounded-circle border border-secondary" src="../'.$User['Image'].'" alt="person" width="32px" height="32px">
                      <h6 class="text-light d-inline-block m-0 p-0">'.preg_split("/@/",$_SESSION['email'])[0].'</h6></a>
                      <ul class="dropdown-menu w-25 position-absolute p-0 m-0" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item text-dark" href="/Resource/inforPer.php?MSKH='.$current_User['MSKH'].'"><i class="fas fa-user-cog"></i> Personal</a></li>
                      <li><a class="dropdown-item text-dark" href="/Resource/Order/"><i class="fas fa-cart-arrow-down"></i> Order Detail</a></li>
                      '.$mode.'
                      <li onclick="logout()"><a class="dropdown-item text-dark" href="#"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
                    </ul>
                      ';
                    }
                  ?>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
    </header>
    
    <section class="order">
     <div class="container">
     <div class="d-flex mt-5 mb-5">
      <?php
        if(!empty($_SESSION)){
          if(isset($_SESSION['email'])){
            echo '
              <ul class="list-group list-group-flush d-none d-sm-block me-5 p-0 infor" height="100px">
                <li class="list-group-item"><h5 class="text-white text-center">Thông tin cá nhân</h5></li>
                <li class="list-group-item">Họ và Tên: '.$User['HoTenKH'].'</li>
                <li class="list-group-item">Số điện thoại: '.$User['SoDienThoai'].'</li>
                <li class="list-group-item">Email: '.$User['Email'].'</li>
                <li class="list-group-item">Địa chỉ: '.$userAddress['DiaChi'].'</li>
              </ul>
        ';
          }
        }
      ?>
        <ul class="list-group list-group-flush m-0 w-100 bill shadow p-1 bg-info rounded">
          <?php
            $count = 1;
            if(!empty($orderId)){
              foreach($orderId as $order){
                $disable = '';
                $confirm = '';
                $orderDetailSql = 'select * from chitietdathang where SoDonDH = "'.$order['SoDonDH'].'"';
                $orderDetail = executeResult($orderDetailSql);

                if($order['trangthai'] === 'Đã xác nhận'){
                  $disable = 'disabled';
                  $confirm = '<a onclick="Confirm('.$order['SoDonDH'].')" class = "btn btn-sm btn-success d-inline-block text-white">Đã giao</a>';
                }


                echo '<li class="list-group-item fw-bold">Đơn hàng thứ '.$count++.':</li>';
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
                      <div>
                        <a onclick="cancelOrder('.$order['SoDonDH'].')" class = "btn btn-sm btn-warning d-inline-block text-white '.$disable.'">Hủy đơn hàng</a>
                        '.$confirm.'
                      </div>
                      </li>
                  ';
                }
              }else{
                echo '<li class="list-group-item text-center">Bạn chưa có đơn đặt hàng nào (☞ﾟヮﾟ)☞</li>';
              }
          ?>
        </ul>
     </div>
     </div>
    </section>

    <footer>
        <div class="container d-block d-lg-flex register">
          <div class="icon">
            <img
              src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/newsletter.png"
              alt="icon"
            />
          </div>
          <div class="description">
            <h3>Đăng kí nhận bản tin H✨Apple</h3>
            <h5>Đừng bỏ lỡ sản phẩm hấp dẫn và chương trình siêu hấp dẫn🎁</h5>
          </div>
          <div class="register-input d-flex pb-1">
            <div>
              <input
                type="email"
                class="form-control"
                placeholder="Địa chỉ email của bạn"
              />
            </div>
            <button type="submit" class="btn btn-sm btn-primary ms-2">SignUp</button>
          </div>
        </div>
        <section class="information">
          <div class="container">
            <div class="row">
              <div class="col-lg-3 col-md-6 col-sm-6">
                <h6>Hỗ trợ khách hàng</h6>
                <ul>
                  <li class="hotline">Hotline chăm sóc khách hàng: 1900-0019</li>
                  <li>Các câu hỏi thường gặp</li>
                  <li>Gửi yêu cầu hổ trợ</li>
                  <li>Hướng dẫn đặt hàng</li>
                  <li>Phương thức vận chuyển</li>
                  <li>Chính sách đổi trả</li>
                  <li>Hướng dẫn trả góp</li>
                  <li>Chính sách hàng nhập khẩu</li>
                  <li>Hổ trợ khách hàng: h_apple@gmail.com</li>
                </ul>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <h6>Về H✨Apple</h6>
                <ul>
                  <li>Giới thiệu H-Apple</li>
                  <li>Tuyển dụng</li>
                  <li>Chính sách bảo mật thanh toán</li>
                  <li>Chính sách bảo mật thông tin cá nhân</li>
                  <li>Chính sách giải quyết khiếu nại</li>
                  <li>Điều khoản sử dụng</li>
                  <li>Hướng dẫn trả góp</li>
                  <li>Bán hàng doanh nghiệp</li>
                </ul>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <h6>Phương thức thanh toán</h6>
                <div class="row img-hover">
                  <div class="col-4 pb-4">
                    <img
                      src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/visa.svg"
                      alt="icon"
                    />
                  </div>
                  <div class="col-4">
                    <img
                      src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/mastercard.svg"
                      alt="icon"
                    />
                  </div>
                  <div class="col-4">
                    <img
                      src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/cash.svg"
                      alt="icon"
                    />
                  </div>
                  <div class="col-4">
                    <img
                      src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/internet-banking.svg"
                      alt="icon"
                    />
                  </div>
                  <div class="col-4">
                    <img
                      src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/installment.svg"
                      alt="icon"
                    />
                  </div>
                  <div class="col-4">
                    <img
                      src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/visa.svg"
                      alt="icon"
                    />
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <h6>Kết nối với chúng tôi</h6>
                <div class="social d-flex">
                  <div class="facebook pb-5">
                    <a href="#">
                      <img
                        src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/fb.svg"
                        alt="fb"
                      />
                    </a>
                  </div>
                  <div class="youtube ps-2 pb-5">
                    <a href="#">
                      <img
                        src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/youtube.svg"
                        alt="ytb"
                      />
                    </a>
                  </div>
                </div>
                <h6>Tải ứng dụng trên điện thoại</h6>
                <div class="download">
                  <div>
                    <a href="#">
                      <img
                        src="https://frontend.tikicdn.com/_desktop-next/static/img/icons/appstore.png"
                        alt="appstore"
                      />
                    </a>
                  </div>
                  <div>
                    <a href="#">
                      <img
                        src="https://frontend.tikicdn.com/_desktop-next/static/img/icons/playstore.png"
                        alt="chplay"
                      />
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section class="address">
          <div class="container">
            <p>
              <strong>Địa chỉ văn phòng</strong>
              Khu II, Đ. 3/2, Xuân Khánh, Ninh Kiều, Cần Thơ <br />
              H✨Apple nhận đặt hàng trực tuyến và giao hàng tận nơi, chưa hỗ trợ
              mua và nhận hàng trực tiếp tại văn <br />
              phòng hoặc trung tâm xử lý đơn hàng
            </p>
          </div>
        </section>
        <section class="copy-right">
          <div class="container d-flex justify-content-between">
            <div>
              <h6>&copy; 2021 - Bản quyền của Công Ty Cổ Phần H✨Apple.vn</h6>
              <p>
                <sub
                  >Giấy chứng nhận Đăng ký Kinh doanh số 099999999 do Sở Kế hoạch
                  và Đầu tư Thành phố Cần Thơ cấp ngày 32/01/2020</sub
                >
              </p>
            </div>
            <div>
              <a href="#">
                <img
                  src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/bo-cong-thuong-2.png"
                  alt="cert1"
                  width="38px"
                />
              </a>
              <a href="#">
                <img
                  src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/bo-cong-thuong.svg"
                  alt="cert2"
                />
              </a>
            </div>
          </div>
        </section>
      </footer>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
      crossorigin="anonymous"
    ></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
       function isNightMode(){
        $.post("/Resource/",{
          "isNightMode": 1,
        },(data)=>{
          location.reload();
        });
      }

      function isLightMode(){
        $.post("/Resource/",{
          "isNightMode": 0,
        },(data)=>{
          location.reload();
        });
      }
       function cancelOrder(id){
        option = confirm("Bạn có thực sự muốn hủy nó ?");
        if(!option){
          return;
        }
        $.post("/Resource/Order/cancel.php", {
          "data": id,
        }, (data)=>{
          location.reload();
        })
      }

      function Confirm(id){
        option = confirm("Cảm ơn bạn đã ủng hộ shop nhé !");
        $.post("/Resource/Order/index.php", {
          "data": id,
        }, (data)=>{
          location.reload();
        })
      }

      function logout(){
        console.log('adad');
        $.post("/Resource/Logout/",{
          "message": "logout",
        },(data)=>{
          location.reload();
        });
      }

      function delProduct(id){
        option = confirm("Bạn có chắn chắn muốn xóa không ?");
        if(!option){
          return;
        }
        $.post("/Resource/inforDel.php",{
          "data": id,
        }, (data)=>{
        });
        window.location.href=window.location;
      }

      function orderProduct(MSHH){
        option = confirm("Chúng tôi sẽ giao hàng cho bạn trong 2 ngày tới. Hoặc bạn có thể nhận trực tiếp tại cửa hàng.");
        if(!option){
          return;
        }
        $.post("/Resource/Order/order.php",{
          "message": "order",
        }, (data)=>{
          window.location.href = window.location;
        }); 
      }
    </script>
  </body>
</html>
