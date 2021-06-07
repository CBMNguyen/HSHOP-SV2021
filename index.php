<?php
  require_once('./Database/config.php');
  session_start();
  if(!empty($_POST)){
   if(isset($_POST['data'])){
    if($_POST['data']==="all"){
      $_SESSION['productFilter'] = "";
    }else{
      $_SESSION['productFilter'] = " and left(MSHH,4) = ".$_POST['data'];
    }
   }else if(isset($_POST['amount'])){
     $_SESSION['amount'] = $_SESSION['amount'] + 1;
   }else if(isset($_POST['isNightMode'])){
    if(isset($_POST['isNightMode'])){
      $_SESSION['isNightMode'] = $_POST['isNightMode'];
    }else{
      $_SESSION['isNightMode'] = 0;
    }
   }
  }else{
    if(!isset($_SESSION['productFilter'])){
      $_SESSION['productFilter'] = '';
    }

    if(!isset($_SESSION['amount'])){
      $_SESSION['amount'] = 1;
    }
    if(!isset($_SESSION['isNightMode'])){
      $_SESSION['isNightMode'] = 0;
    }
  }
  
  if(empty($_SESSION) || !isset($_SESSION['product']) || !isset($_SESSION['email'])){
    $_SESSION['product'] = [];
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Hieu Nguyen" />
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
    <link rel="stylesheet" href="./main.css" />
    <link rel="stylesheet" href="./css/home.css" />
    <link
      href="./font-awesome/fontawesome-free-5.15.3-web/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./css/query.css" />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    <title>H✨Apple.com - Điện Thoại, Laptop Apple Uy Tín ...</title>
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
      .slide{
        width: 69%;
      }

      .homenews{
        max-width: 30%;
        margin-left: 1%;
      }

      .homenews h6{
        padding: 0;
        margin: 0;
        width: 150px;
        font-size: 0.9rem;
        background-color: #fdd504;
        padding: 10px 10px 10px 5px;
        position: relative;
      }

      figure{
        border-bottom: 1px solid #ededed;
        background-color: white;
        margin: 0;
      }

      .homenews h6 a{
        text-decoration: none;
        color: black;
      }

      .homenews h6:after{
        content: '';
        width: 0;
        height: 0;
        border-right: 12px solid #fff;
        border-top: 20px solid transparent;
        border-bottom: 20px solid transparent;
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
      }

      .news{
        background-color: white;
        padding: 5px;
      }

      .homenews .news a{
        text-decoration: none;
        font-size: 14px;
      }

      .homenews .news .title{
        line-height: 110%;
      }

      .pagination a{
        margin: auto;
        font-size: 14px;
        margin-bottom: 5px;
        display: inline-block;
        text-decoration: none;
        padding: 5px 50px;
        border: 1px solid #ededed;
      }

      .pagination a:hover{
        cursor: pointer;
        background-color: #288ad6;
        color: #fff !important;
      }

      .cart:hover .showCart{
        display: block;
      }

      .showCart:hover{
        display: block;
      }

      .showCart{
        width: 380px;
        background-color: #fff;
        width: 360px;
        font-size: 0.8rem;
        position: absolute;
        top: 45px;
        margin-top: 6px;
        padding: 5px;
        z-index: 2;
        display:none;
        transition: all 0.45s ease-in-out 0s;
      }

      .cart{
        transition: all 0.45s ease-in-out 0s;
      }

      .showCart .product-item{
        border-bottom: 1px solid #ccc;
        background-color: white;
      }

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

    </style>
  </head>

  <body>
    <!-- ====================Header==================== -->

    <header>
    <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container">
            <a class="navbar-brand" href="/Resource"
              ><img src="./img/logo1.png" alt="l0go1" width="50px" height="50px"
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
              <ul class="navbar-nav me-0 mb-2 mb-lg-0 d-flex">
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
                                    <img class="p-2" src="'.$currentProduct['thumbnail'].'" alt="#" width="60px" height="60px">
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
                            <div class="d-flex align-items-center mb-2 product-item">
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
                      $User = executeResultOne($sql);

                      if($_SESSION['isNightMode'] === "1"){
                        $mode = '<li><a class="dropdown-item text-dark" onclick="isLightMode()"><i class="fas fa-sun"></i> Light Mode</a></li>';
                      }
                      echo '
                      <img class="rounded-circle border border-secondary" src="'.$User['Image'].'" alt="person" width="32px" height="32px">
                      <h6 class="text-light d-inline-block m-0 p-0">'.preg_split("/@/",$_SESSION['email'])[0].'</h6></a>
                      <ul class="dropdown-menu w-25 position-absolute a p-0 m-0" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item text-dark" href="/Resource/inforPer.php?MSKH='.$User['MSKH'].'"><i class="fas fa-user-cog"></i> Personal</a></li>
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

      <section class="carousel-slide mt-2">
        <div class="container d-flex">
          <div
            id="carouselExampleIndicators"
            class="carousel slide"
            data-bs-ride="carousel"
          >
            <div class="carousel-indicators">
              <button
                type="button"
                data-bs-target="#carouselExampleIndicators"
                data-bs-slide-to="0"
                class="active"
                aria-current="true"
                aria-label="Slide 1"
              ></button>
              <button
                type="button"
                data-bs-target="#carouselExampleIndicators"
                data-bs-slide-to="1"
                aria-label="Slide 2"
              ></button>
              <button
                type="button"
                data-bs-target="#carouselExampleIndicators"
                data-bs-slide-to="2"
                aria-label="Slide 3"
              ></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="./img/slide1.jpg" class="d-block w-100" alt="..." />
              </div>
              <div class="carousel-item">
                <img src="./img/slide2.jpg" class="d-block w-100" alt="..." />
              </div>
              <div class="carousel-item">
                <img src="./img/slide3.jpg" class="d-block w-100" alt="..." />
              </div>
            </div>
            <button
              class="carousel-control-prev"
              type="button"
              data-bs-target="#carouselExampleIndicators"
              data-bs-slide="prev"
            >
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button
              class="carousel-control-next"
              type="button"
              data-bs-target="#carouselExampleIndicators"
              data-bs-slide="next"
            >
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          <div class="homenews">
            <figure>
              <div>
                  <h6>
                    <a href="#">24H CÔNG NGHỆ</a>
                  </h6>
              </div>
            </figure>
            <div class="news d-flex">
                <img src="./img/news.png" class="pt-1" width="50%" height="50%" alt="#">
              <div class="p-0 ms-2 title">
                <a href="https://www.thegioididong.com/tin-tuc/danh-gia-iphone-11-cap-nhat-ios-14-5-1346615" target="_blank">
                  Đánh giá iPhone 11 cập nhật iOS 14.5: Tuyệt vời khi tăng hiệu năng, pin ngon hơn
                </a>
              </div>  
            </div>
            <div class="mt-2">
              <a href="#MYD92SA/A">
                <img src="./img/mac-banner.png" width="100%" height="100%" alt="banner-home">
              </a>
            </div>
            <div class="mt-2">
              <a href="#ip11128green">
                <img src="./img/news-ip1-banner.png" width="100%" height="100%" alt="banner-home">
              </a>
            </div>
          </div>
        </div>
      </section>
      <section class="mt-2">
        <div class="container">
        <!-- https://www.thegioididong.com/tin-tuc/mach-ban-cach-mua-dien-thoai-online-gia-re-nhat-1340156 -->
          <a href="https://www.thegioididong.com/flashsale" target="_blank">
            <div class="banner-img banner img-fluid"></div>
          </a>
        </div>
      </section>
    </header>

    <!-- ============================================== -->

    <!-- ====================Products================== -->

    <div class="main mt-2">
      <section class="product">
        <div class="container p-4 pt-0">
          <div class="row shadow-sm pt-2 mb-3 bg-body rounded">
            <div class="product__title">
              <h3 class="d-flex">
                IPhone🎊
                <select class="form-select" onchange="productFilter(this)" aria-label="Default select example">
                  <option <?=$_SESSION['productFilter'] === '' ? 'selected' : ''?> value="all">Show all</option>
                  <option <?=substr($_SESSION['productFilter'],21,4) === 'ipol' ? 'selected' : ''?> value="ipol">6,7,8 series</option>
                  <option <?=substr($_SESSION['productFilter'],21,4) === 'ipse' ? 'selected' : ''?> value="ipse">SE series</option>
                  <option <?=substr($_SESSION['productFilter'],21,4) === 'ipxs' ? 'selected' : ''?> value="ipxs">XS series</option>
                  <option <?=substr($_SESSION['productFilter'],21,4) === 'ip11' ? 'selected' : ''?> value="ip11">11 series</option>
                  <option <?=substr($_SESSION['productFilter'],21,4) === 'ip12' ? 'selected' : ''?> value="ip12">12 series</option>
                </select>
              </h3>
            </div>
            
            
            <?php 
              $sql = 'select * from hanghoa where MaLoaiHang = 1'.$_SESSION['productFilter'].'';
              $result = array_slice(executeResult($sql), 0, 12*$_SESSION['amount']);
              foreach ($result as $product){
                echo '
                  <div
                    class="col col-xl-2 col-lg-3 col-md-4 shadow-sm p-3 mb-2 bg-body rounded"
                    id="'.$product['MSHH'].'"
                  >
                  <a href="/Resource/infor.php?code='.$product['MSHH'].'">
                    <div class="label">
                      <span>Trả góp <b>'.$product['TraGop'].'</b>%</span>
                    </div>
                    <img src="'.$product['thumbnail'].'" alt="ip" width="200px" />
                    <div class="product__info">
                      <div class="product__name">'.$product['TenHH'].'</div>
                      <div class="product__price">
                        <strong>'.number_format($product['GiamGia'], 0, '.', '.').'</strong>
                        <span>'.number_format($product['Gia'], 0, '.', '.').' <sup>đ</sup></span>
                        <span>'.round(($product['Gia'] - $product['GiamGia']) * 100/$product['Gia'], 1).'%</span>
                      </div>
                    </div>
                    <ul class="product__description">
                      <li>'.$product['ScreenSize'].'", '.$product['Chip'].'</li>
                      <li>Ram '.$product['Ram'].', ROM '.$product['Rom'].'</li>
                      <li>Camera sau: '.$product['CamS'].'</li>
                      <li>Camera trước: '.$product['CamTR'].'</li>
                      <li>Pin '.$product['Pin'].', '.$product['CapSac'].'</li>
                    </ul>
                  </a>
            </div>';
              }
            ?>
          <div class="pagination w-100">
           <?php
           $ishidden = $_SESSION['amount'] * 12 > count(executeResult($sql)) ? "d-none" : "";
            echo '
              <a onclick="seemoreProduct()" class="text-center text-primary '.$ishidden.' ">Xem Thêm '.count(executeResult($sql))-$_SESSION['amount'] * 12 .' điện thoại <i class="fas fa-caret-down"></i></a>
            ';
           ?>
           
          </div>
          </div>

          <div class="row shadow-sm pt-2 mb-2 bg-body rounded">
          <h3 class="macbook__title">MacBook🎊</h3>
          <?php 
            $sql = 'select * from hanghoa where MaLoaiHang = 2';
            $result = executeResult($sql);
            foreach($result as $product){
              echo '
              <div class="col col-lg-3 col-md-6 shadow-sm p-3 mb-2 bg-body rounded" id="'.$product['MSHH'].'">
              <a href="/Resource/infor.php?code='.$product['MSHH'].'">
                <div class="label">
                  <span>Trả góp <b>'.$product['TraGop'].'</b>%</span>
                </div>
                <img src="'.$product['thumbnail'].'" alt="mac" width="200px" />
                <div class="product__info">
                  <div class="product__name">'.$product['TenHH'].'</div>
                  <div class="product__code">('.$product['MSHH'].')</div>
                  <div class="product__price">
                    <strong>'.number_format($product['GiamGia'], 0, '.', '.').'</strong>
                    <span>'.number_format($product['Gia'], 0, '.', '.').' <sup>đ</sup></span>
                    <span>'.round(($product['Gia'] - $product['GiamGia']) * 100/$product['Gia'], 1).'%</span>
                  </div>
                </div>
                <ul class="product__description">
                  <li>Màn hình: '.$product['ScreenSize'].', '.$product['ScreenTech'].'</li>
                  <li>CPU: '.$product['Chip'].'</li>
                  <li>RAM: '.$product['Ram'].'</li>
                  <li>SSD: '.$product['Ssd'].'</li>
                  <li>Đồ họa: '.$product['DoHoa'].'</li>
                  <li>Nặng '.$product['TrongLuong'].', '.$product['ThoiLuongPin'].'</li>
                </ul>
              </a>
            </div>
              ';
            }
          ?>
        </div>
        </div>
      </section>
    </div>

    <!-- ============================================== -->
    <!-- =====================Footer=================== -->

    <footer>
      <div class="container d-block d-lg-flex register pb-1">
        <div class="icon">
          <img src="./img/newsletter.png" alt="letter-icon" />
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
                  <img src="./img/visa.svg" alt="visa" />
                </div>
                <div class="col-4">
                  <img src="./img/mastercard.svg" alt="icon" />
                </div>
                <div class="col-4">
                  <img src="./img/jcb.svg" alt="icon" />
                </div>
                <div class="col-4">
                  <img src="./img/internet-banking.svg" alt="icon" />
                </div>
                <div class="col-4">
                  <img src="./img/installment.svg" alt="icon" />
                </div>
                <div class="col-4">
                  <img src="./img/cash.svg" alt="icon" />
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <h6>Kết nối với chúng tôi</h6>
              <div class="social d-flex">
                <div class="facebook pb-5">
                  <a
                    href="https://www.facebook.com/profile.php?id=100008660230676"
                  >
                    <img src="./img/fb.svg" alt="fb" />
                  </a>
                </div>
                <div class="youtube ps-2 pb-5">
                  <a
                    href="https://studio.youtube.com/channel/UCiXdWR-IaD5jS6TxBWATqnQ/videos/upload?filter=%5B%5D&sort=%7B%22columnType%22%3A%22date%22%2C%22sortOrder%22%3A%22DESCENDING%22%7D"
                  >
                    <img src="./img/youtube.svg" alt="ytb" />
                  </a>
                </div>
              </div>
              <h6>Tải ứng dụng trên điện thoại</h6>
              <div class="download">
                <div>
                  <a href="#">
                    <img src="./img/appstore.png" alt="appstore" />
                  </a>
                </div>
                <div>
                  <a href="#">
                    <img src="./img/playstore.png" alt="chplay" />
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
                >Giấy chứng nhận Đăng ký Kinh doanh số 01122000 do Sở Kế hoạch
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
      
      function logout(){
        $.post("/Resource/Logout/",{
          "message": "logout",
        },(data)=>{
          location.reload();
        });
      }

      function productFilter(select){
        let data = `"${select.value}"`;
        if(select.value === "all"){
          data = "all";
        }
        $.post("/Resource/",{
          "data": data,
        },(data)=>{
          location.reload();
        });
      }

      function seemoreProduct(){
        $.post("/Resource/",{
          "amount": 1,
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
        window.location.href = window.location;
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
