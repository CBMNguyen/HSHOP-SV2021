<?php
  session_start();
  require_once('./Database/config.php');
  if(empty($_SESSION)){
    $_SESSION['product'] = [];
    $_SESSION['isNightMode'] = 0;
    $_POST = [];
  }

  $MSHH = '';
  $product = '';
  $phoneColor = '';
    if(!empty($_GET)) {
      if(isset($_GET['code'])){
        $MSHH = $_GET['code'];
        $sql = 'select * from hanghoa where hanghoa.MSHH = "'.$MSHH.'" ';
        $phoneColorSql = 'select * from hanghoa where left(MSHH, 4) = "'.substr($MSHH, 0, 4).'" and MSHH != "'.$MSHH.'"';
        $phoneColor = executeResult($phoneColorSql);
        $product = executeResultOne($sql);
        if(empty($product)){
          require_once('./NotFound/index.php');
          die();
        }
        }else{
          echo '<h1>Page Not Found</h1>';
          die();
        }
      }else{
        echo '<h1>Page Not Found</h1>';
          die();
    }
    $check = 0;
    $index = 0;
    if(!empty($_POST)){
      if(isset($_SESSION['product'])){
        foreach($_SESSION['product'] as $item){
          if($item[0] === $product['MSHH']){
            $_SESSION['product'][$index][1] = $_POST['amount'];
            $check = 1;
          }
          $index++;
        }
        if(!$check){
          $item = [$product['MSHH'], $_POST['amount']];
          array_push($_SESSION['product'], $item);
        }
      }

      if(isset($_POST['data'])){
        if($_POST['data']==="all"){
          // $_SESSION['productFilter'] = "";
        }else{
          // $_SESSION['productFilter'] = " and left(MSHH,4) = ".$_POST['data'];
        }
       }else if(isset($_POST['amount'])){
        //  $_SESSION['amount'] = $_SESSION['amount'] + 1;
       }else if(isset($_POST['isNightMode'])){
        if(isset($_POST['isNightMode'])){
          $_SESSION['isNightMode'] = $_POST['isNightMode'];
        }else{
          $_SESSION['isNightMode'] = 0;
        }
       }
      }else{
        if(!isset($_SESSION['productFilter'])){
          // $_SESSION['productFilter'] = '';
        }
    
        if(!isset($_SESSION['amount'])){
          // $_SESSION['amount'] = 1;
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
    <link rel="stylesheet" href="./css/index.css" />
    <link rel="stylesheet" href="./css/query.css" />
    <link
      href="./font-awesome/fontawesome-free-5.15.3-web/css/all.min.css"
      rel="stylesheet"
    />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    <?php
      echo '<title>'.$product['TenHH'].'</title>'
    ?>
    <style>
      <?php
        if($_SESSION['isNightMode'] === "1"){
          echo '
            body, .information, .address, .copy-right, .product-infor{
              background-color: black !important;
            }

            .product-infor .container{
              background-color: white !important;
              color: #333 !important;
            }

            footer ul li:hover{
              color: rgb(240, 219, 28);
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
    </style>
  </head>
  <body>
    <div class="wrapper">
      <header>
        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container">
            <a class="navbar-brand" href="/Resource"
              ><img src="./img/logo1.png" alt="l0go1" width="50px" height="50px"
            /></a>
            <a class="navbar-brand me-5 pt-3 text-light" href="/Resource"><h5>H???APPLE</h5></a>
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
                  placeholder="H??y t??m s???n ph???m y??u th??ch c???a b???n ... ????"
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
                        <span>Gi??? h??ng</span>
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
                            foreach($_SESSION['product'] as $item){
                              $sql = 'select * from hanghoa where MSHH = "'.$_SESSION['product'][$index][0].'"';
                              $currentProduct = executeResultOne($sql);
                              $option = "Rom: ".$currentProduct['Rom'];
                              if($currentProduct['MaLoaiHang'] === "2"){
                                $option = "Ssd: ".$currentProduct['Ssd'];
                              }
                              echo '
                              <a href="/Resource/infor.php?code='.$currentProduct['MSHH'].'" class="text-decoration-none text-dark">
                                <div class="d-flex align-items-center mb-2 product-item pb-2">
                                  <img class="p-2" src="'.$currentProduct['thumbnail'].'" alt="#" width="60px" height="60px">
                                  <div class="flex-grow-1">
                                    <h6 class="p-0 m-0">'.$currentProduct['TenHH'].'</h6>
                                    <div>Ram: '.$currentProduct['Ram'].' &nbsp;&nbsp;&nbsp;&nbsp;'.$option.'</div>
                                    <div>S??? l?????ng: '.$_SESSION['product'][$index][1].' &nbsp;&nbsp;Gi??: '.number_format($_SESSION['product'][$index][1]*$currentProduct['GiamGia'], 0, '.', '.').'</div>
                                  </div>
                                  <div onclick="delProduct(this.id)" id='.$currentProduct['MSHH'].' class="ps-2 pe-2 close"><i class="fas fa-times fa-lg"></i></div>
                                </div>
                                </a>
                              ';
                              $money += $currentProduct['GiamGia']*$_SESSION['product'][$index][1];
                              $index++;
                            }
                            if(count($_SESSION['product']) !== 0){
                              $function = "onclick=orderProduct("."'$MSHH'".")";
                              echo '
                                <div>
                                <div class="d-flex align-items-center justify-content-between p-2">
                                  <h6 class="p-0 m-0">T???ng s??? ti???n: <span class="text-danger">'.number_format($money, 0, '.', '.').'<sup>??</sup></span></h6>
                                  <a '.$function.' class="btn btn-warning text-light">Mua Ngay</a>
                                </div>
                              </div>
                            ';
                            }else{
                              echo '
                                <div class="d-flex align-items-center product-item">
                                <div class="text-success m-auto p-0 m-0">????Gi??? h??ng r???ng...????</div> 
                                </div>
                              ';
                            }
                          }
                        }else{
                          echo '
                            <div class="d-flex align-items-center mb-2 product-item">
                            <div class="text-success m-auto">????Gi??? h??ng r???ng...????</div> 
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
                        <h6 class="text-light d-inline-block">????????????? Customers</h6></a>
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
                      <ul class="dropdown-menu w-25 position-absolute p-0 m-0" aria-labelledby="navbarDropdown">
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

        <form class="p-3 option" method="POST">
            <div class="position-relative">
              <div onclick="exit()" class="position-absolute close"><i class="fas fa-times fa-lg"></i></div>
              <h5>??i???n Tho???i <?=$product['TenHH']?></h5>
              <div>
                <strong class= "text-danger"><?=number_format($product['GiamGia'], 0, '.', '.')?></strong>
                <span class="text-secondary d-inline-block ms-3"><strike><?=number_format($product['Gia'], 0, '.', '.')?><sup>??</sup></strike></span>
              </div>
              <hr>
              <div class="container">
                <div class="row">
                  <div class="col-4 mb-1">
                    <a href="#" class="text-decoration-none">
                    <img class="pt-2 pb-2 border border-secondary" src="<?=$product['thumbnail']?>" 
                    alt="ip" width="50px" height="50px"
                    title="<?=$phone['TenHH']?>">
                    </a>
                  </div>
                  <?php
                  foreach($phoneColor as $phone){
                    echo '
                    <div class="col-4 mb-1">
                      <img class="pt-2 pb-2" src="'.$phone['thumbnail'].'" alt="ip" width="50px" height="50px" title="'.$phone['TenHH'].'">
                    </div>
                    ';
                  }
                ?>
                </div>
              </div>
              <div>
              </div>
              <div class="d-flex align-items-center w-75 mt-3">
                <h6 class="me-2">Ch???n s??? l?????ng: </h6>
                <input class="w-25 text-center" type="number" min="1" max="<?=$product['SoLuongHang']?>" name = "amount" value="1">
              </div>
              <button type="submit" class="btn btn-warning w-100 d-block m-auto mt-3 text-light">Add to Cart</button>
            </div>
        </form>
      
      <section class="product-infor">
        <div class="container">
          <?php
            $function = "onclick=addToCart()";
            if(!empty($_SESSION)){
              if(!isset($_SESSION['email'])){
                $function = 'onclick=checkUser(this.id)';
              }
            }
            if($product['MaLoaiHang'] === "1"){
              echo '
                <h3>'.$product['TenHH'].'</h3>
                <hr>
                <div class="row">
                  <div class="col-lg-5 col-md-6 col-mySlides">
                    <div class="container">
                      <div class="mySlides">
                          <div class="numbertext">1 / '.count($phoneColor)+1 .'</div>
                          <img src="'.$product['thumbnail'].'" class="ms-3" style="width:100%">
                      </div>';
                
                    $number = 2;
                    foreach($phoneColor as $phone){
                      echo '
                        <div class="mySlides">
                        <div class="numbertext">'.$number.' / '.count($phoneColor) + 1 .'</div>
                          <a href="/Resource/infor.php?code='.$phone['MSHH'].'"><img src="'.$phone['thumbnail'].'" class="ms-3" style="width:100%"></a>
                        </div>
                        ';
                        $number++;
                    }
              
                
                  // <!-- Next and previous buttons -->
                  echo '
                    <a class="prev"  onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next"  onclick="plusSlides(1)">&#10095;</a>
                    
                    <div class="caption-container">
                      <p id="caption"></p>
                    </div>
                  
                    <div class="row">
                    <div class="column">
                        <img class="demo cursor" src="'.$product['thumbnail'].'" style="width:100%" onclick="currentSlide(1)" alt="'.$product['TenHH'].'">
                      </div>
                    ';
                    $number = 2;
                      foreach($phoneColor as $phone){
                        echo '
                        <div class="column">
                        <a href="/Resource/infor.php?code='.$phone['MSHH'].'"><img class="demo cursor" src="'.$phone['thumbnail'].'" style="width:100%" onclick="currentSlide('.$number.')" alt="'.$phone['TenHH'].'"></a>
                        </div>
                        ';
                        $number++;
                      }
                    echo '
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <h3 class="pt-2">Th??ng s??? k??? thu???t</h3>
                  <ul class="list-infor">
                    <li>M??n h??nh: <a href="#">'.$product['ScreenTech'].'</a></li>
                    <li>H??? ??i???u h??nh: '.$product['HeDieuHanh'].'</li>
                    <li>Camera sau: '.$product['CamS'].'</li>
                    <li>Camera tr?????c: '.$product['CamTR'].'</li>
                    <li>Chip x??? l??: <a href="#">'.$product['Chip'].'</a></li>
                    <li><a href="#">RAM:</a> '.$product['Ram'].'</li>
                    <li><a href="#">ROM:</a> '.$product['Rom'].'</li>
                    <li>SIM: <a href="#">'.$product['Sim'].'</a></li>
                    <li>Pin: '.$product['Pin'].', '.$product['CapSac'].'</li>
                  </ul>
                  <button '.$function.' id='.$MSHH.' class="btn w-100"><strong>Th??m v??o gi??? h??ng</strong> <br> <sub>Giao h??ng t???n n??i ho???c nh???n t???i si??u th???</sub></button>
                </div>

                <div class="col-lg-3 col-md-12 promotion mt-1">
                <div class="title">
                    <h6>KHUY???N M??I</h6>
                    <span><small>Gi?? v?? khuy???n m??i ??p d???ng ?????n h???t 23:00 30/04</small></span>
                </div>
                <ul>
                  <li class="d-flex">
                    <i class="fas fa-check-circle pt-2 pe-2"></i>
                    <div>
                      <span>Gi???m gi?? 1,000,000?? khi tham gia thu c?? ?????i m???i</span>
                      <a href="https://www.thegioididong.com/thu-cu-doi-moi" target="_blank">Xem chi ti???t</a>
                    </div>
                  </li>
                  <li class="d-flex">
                    <i class="fas fa-check-circle pt-2 pe-2"></i>
                    <div>
                      <span>Gi???m 50% gi?? mua g??i b???o hi???m r??i v??? 6 th??ng</span>
                      <a href="https://www.thegioididong.com/tin-tuc/duoc-giam-gia-goi-bao-hiem-roi-vo-khi-mua-kem-iphone-1331129" target="_blank">Xem chi ti???t</a>
                    </div>
                  </li>
                  <li>
                    <div>
                      <span><strong class="text-danger">(*)</strong> Gi?? ho???c khuy???n m??i kh??ng ??p d???ng ?????i v???i 1 s??? g??i tr??? g??p</span>
                    </div>
                  </li>
                </ul>
                <div class="title">
                    <h6>??U ????I TH??M</h6>
                    <span><small>Gi?? v?? khuy???n m??i ??p d???ng ?????n h???t 23:00 30/04</small></span>
                </div>
                <ul>
                  <li class="d-flex">
                    <i class="fas fa-check-circle pt-2 pe-2"></i>
                    <div>
                      <span>T???ng cho kh??ch l???n ?????u mua h??ng online t???i web</span>
                      <a href="https://www.bachhoaxanh.com/?utm_source=tgdd_ttc_tct_20%&utm_medium=link_tct&utm_campaign=tgdd" target="_blank">BachhoaXanh.com</a>
                    </div>
                  </li>
                  <li>
                      <ul class="sub-infor">
                        <li>Ma?? gia??m <span><strong>20% t????i ??a 100.000??</strong></span></li>
                        <li>5 l???n <span><strong>FREEship</strong></span></li>
                      </ul>
                  </li>
              </ul>
              </div>
              </div>';
            }else{
              echo '
                <h3>'.$product['TenHH'].'</h3>
                <hr>
                <div class="row">
                  <div class="col-lg-5 col-md-6 col-mySlides">
                    <div class="container">
                      <div class="mySlides">
                          <div class="numbertext">1 / '.count($phoneColor)+1 .'</div>
                          <img src="'.$product['thumbnail'].'" class="ms-3" style="width:100%">
                      </div>';
                
                    $number = 2;
                    foreach($phoneColor as $phone){
                      echo '
                        <div class="mySlides">
                        <div class="numbertext">'.$number.' / '.count($phoneColor) + 1 .'</div>
                          <a href="/Resource/infor.php?code='.$phone['MSHH'].'"><img src="'.$phone['thumbnail'].'" class="ms-3" style="width:100%"></a>
                        </div>
                        ';
                        $number++;
                    }
              
                
                  // <!-- Next and previous buttons -->
                  echo '
                    <a class="prev"  onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next"  onclick="plusSlides(1)">&#10095;</a>
                    
                    <div class="caption-container">
                      <p id="caption"></p>
                    </div>
                  
                    <div class="row">
                    <div class="column">
                        <img class="demo cursor" src="'.$product['thumbnail'].'" style="width:100%" onclick="currentSlide(1)" alt="'.$product['TenHH'].'">
                      </div>
                    ';
                    $number = 2;
                      foreach($phoneColor as $phone){
                        echo '
                        <div class="column">
                        <a href="/Resource/infor.php?code='.$phone['MSHH'].'"><img class="demo cursor" src="'.$phone['thumbnail'].'" style="width:100%" onclick="currentSlide('.$number.')" alt="'.$phone['TenHH'].'"></a>
                        </div>
                        ';
                        $number++;
                      }
                    echo '
                  </div>
                </div>
              </div>
                <div class="col-lg-4 col-md-6">
                  <h3 class="pt-2">Th??ng s??? k??? thu???t</h3>
                  <ul class="list-infor">
                    <li>CPU: <a href="https://www.thegioididong.com/hoi-dap/tim-hieu-ve-chip-apple-m1-con-chip-arm-5nm-dau-tien-danh-1305955" target="_blank">'.$product['Chip'].'</a></li>
                    <li>Ram: '.$product['Ram'].'</li>
                    <li>??? c???ng: '.$product['Ssd'].'</li>
                    <li>M??n h??nh: '.$product['ScreenSize'].' inch, '.$product['ScreenTech'].'</li>
                    <li>Card m??n h??nh: <a href="https://www.thegioididong.com/hoi-dap/card-do-hoa-tich-hop-la-gi-950047" target="_blank">'.$product['ScreenCard'].'</a></li>
                    <li>H??? ??i???u h??nh: <a href="https://www.thegioididong.com/hoi-dap/mac-os-la-gi-838020" target="_blank">'.$product['HeDieuHanh'].'</a></li>
                    <li>Thi???t k???: '.$product['Design'].'</li>
                    <li>Th???i ??i???m ra m???t: '.substr($product['Created_at'], 0, 4).'</li>
                  </ul>
                    <button '.$function.' class="btn w-100"><strong>Th??m v??o gi??? h??ng</strong> <br> <sub>Giao h??ng t???n n??i ho???c nh???n t???i si??u th???</sub></button>
                </div>
                <div class="col-lg-3 col-md-12 promotion mt-1">
                  <div class="title">
                      <h6>KHUY???N M??I</h6>
                      <span><small>Gi?? v?? khuy???n m??i ??p d???ng ?????n h???t 23:00 30/04</small></span>
                  </div>
                  <ul>
                    <li class="d-flex">
                      <i class="fas fa-check-circle pt-2 pe-2"></i>
                      <div>
                        <span>Gi???m gi?? 1,000,000?? khi tham gia thu c?? ?????i m???i</span>
                        <a href="https://www.thegioididong.com/thu-cu-doi-moi" target="_blank">Xem chi ti???t</a>
                      </div>
                    </li>
                    <li class="d-flex">
                      <i class="fas fa-check-circle pt-2 pe-2"></i>
                      <div>
                        <span>Gi???m 50% gi?? mua g??i b???o hi???m r??i v??? 6 th??ng</span>
                        <a href="https://www.thegioididong.com/tin-tuc/duoc-giam-gia-goi-bao-hiem-roi-vo-khi-mua-kem-iphone-1331129" target="_blank">Xem chi ti???t</a>
                      </div>
                    </li>
                    <li>
                      <div>
                        <span><strong class="text-danger">(*)</strong> Gi?? ho???c khuy???n m??i kh??ng ??p d???ng ?????i v???i 1 s??? g??i tr??? g??p</span>
                      </div>
                    </li>
                  </ul>
                  <div class="title">
                      <h6>??U ????I TH??M</h6>
                      <span><small>Gi?? v?? khuy???n m??i ??p d???ng ?????n h???t 23:00 30/04</small></span>
                  </div>
                  <ul>
                    <li class="d-flex">
                      <i class="fas fa-check-circle pt-2 pe-2"></i>
                      <div>
                        <span>T???ng cho kh??ch l???n ?????u mua h??ng online t???i web</span>
                        <a href="https://www.bachhoaxanh.com/?utm_source=tgdd_ttc_tct_20%&utm_medium=link_tct&utm_campaign=tgdd" target="_blank">BachhoaXanh.com</a>
                      </div>
                    </li>
                    <li>
                        <ul class="sub-infor">
                          <li>Ma?? gia??m <span><strong>20% t????i ??a 100.000??</strong></span></li>
                          <li>5 l???n <span><strong>FREEship</strong></span></li>
                        </ul>
                    </li>
                </ul>
                </div>
              </div>';
            }
          ?>
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
            <h3>????ng k?? nh???n b???n tin H???Apple</h3>
            <h5>?????ng b??? l??? s???n ph???m h???p d???n v?? ch????ng tr??nh si??u h???p d???n????</h5>
          </div>
          <div class="register-input d-flex pb-1">
            <div>
              <input
                type="email"
                class="form-control"
                placeholder="?????a ch??? email c???a b???n"
              />
            </div>
            <button type="submit" class="btn btn-sm btn-primary ms-2">SignUp</button>
          </div>
        </div>
        <section class="information">
          <div class="container">
            <div class="row">
              <div class="col-lg-3 col-md-6 col-sm-6">
                <h6>H??? tr??? kh??ch h??ng</h6>
                <ul>
                  <li class="hotline">Hotline ch??m s??c kh??ch h??ng: 1900-0019</li>
                  <li>C??c c??u h???i th?????ng g???p</li>
                  <li>G???i y??u c???u h??? tr???</li>
                  <li>H?????ng d???n ?????t h??ng</li>
                  <li>Ph????ng th???c v???n chuy???n</li>
                  <li>Ch??nh s??ch ?????i tr???</li>
                  <li>H?????ng d???n tr??? g??p</li>
                  <li>Ch??nh s??ch h??ng nh???p kh???u</li>
                  <li>H??? tr??? kh??ch h??ng: h_apple@gmail.com</li>
                </ul>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <h6>V??? H???Apple</h6>
                <ul>
                  <li>Gi???i thi???u H-Apple</li>
                  <li>Tuy???n d???ng</li>
                  <li>Ch??nh s??ch b???o m???t thanh to??n</li>
                  <li>Ch??nh s??ch b???o m???t th??ng tin c?? nh??n</li>
                  <li>Ch??nh s??ch gi???i quy???t khi???u n???i</li>
                  <li>??i???u kho???n s??? d???ng</li>
                  <li>H?????ng d???n tr??? g??p</li>
                  <li>B??n h??ng doanh nghi???p</li>
                </ul>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <h6>Ph????ng th???c thanh to??n</h6>
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
                <h6>K???t n???i v???i ch??ng t??i</h6>
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
                <h6>T???i ???ng d???ng tr??n ??i???n tho???i</h6>
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
              <strong>?????a ch??? v??n ph??ng</strong>
              Khu II, ??. 3/2, Xu??n Kh??nh, Ninh Ki???u, C???n Th?? <br />
              H???Apple nh???n ?????t h??ng tr???c tuy???n v?? giao h??ng t???n n??i, ch??a h??? tr???
              mua v?? nh???n h??ng tr???c ti???p t???i v??n <br />
              ph??ng ho???c trung t??m x??? l?? ????n h??ng
            </p>
          </div>
        </section>
        <section class="copy-right">
          <div class="container d-flex justify-content-between">
            <div>
              <h6>&copy; 2021 - B???n quy???n c???a C??ng Ty C??? Ph???n H???Apple.vn</h6>
              <p>
                <sub
                  >Gi???y ch???ng nh???n ????ng k?? Kinh doanh s??? 099999999 do S??? K??? ho???ch
                  v?? ?????u t?? Th??nh ph??? C???n Th?? c???p ng??y 32/01/2020</sub
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
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
      crossorigin="anonymous"
    ></script>
    <script src="./js/slide.min.js"></script>
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
      
      function delProduct(id){
        option = confirm("B???n c?? th???t s??? mu???n x??a kh??ng ?");
        if(!option){
          return;
        }
        $.post("/Resource/inforDel.php",{
          "data": id,
        }, (data)=>{
        });
        window.location.href=location.href;
      }

      function checkUser(MSHH){
        console.log(MSHH);
        option = confirm("Vui l??ng ????ng nh???p tr?????c khi th??m v??o gi??? h??ng");
        if(!option){
          return;
        }
        window.location.href = `/Resource/SignIn?previous=${MSHH}`;
      }

      function addToCart(){
        $('.option').show();
        $('.wrapper').addClass('overlay');
        $('body').css('overflow','hidden');
      }

      function exit(){
        $('.option').hide();
        $('.wrapper').removeClass('overlay');
        $('body').css('overflow','auto');
      }

      function orderProduct(MSHH){
        option = confirm("Ch??ng t??i s??? giao h??ng cho b???n trong 2 ng??y t???i. Ho???c b???n c?? th??? nh???n tr???c ti???p t???i c???a h??ng.");
        if(!option){
          return;
        }
        $.post("/Resource/Order/order.php",{
          "message": "order",
        }, (data)=>{
          window.location.href = `/Resource/infor.php?code=${MSHH}`;
        }); 
      }

      function logout(){
        $.post("/Resource/Logout/index.php",{
          "message": "logout",
        },(data)=>{
          location.reload();
        });
      }
    </script>
  </body>
</html>
