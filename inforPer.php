<?php
  require_once('./Database/config.php');
  session_start();
  $name = $company = $address = $phone = $email = $password = $oldPhone = $MSKH = $image_url = $fileName ='';
  $checkTypeFile = true;
  $checkSelectFile = true;
  $image = './img/person.jpg';

  if(!empty($_GET)){

    $checkSql = 'select * from khachhang where MSKH = "'.$_GET['MSKH'].'"';
    $isCustomer = executeResultOne($checkSql);
    $userAddressSql = 'select DiaChi from diachikh where MSKH = "'.$_GET['MSKH'].'"';
    $userAddress = executeResultOne($userAddressSql);
    if(empty($isCustomer) || !isset($_SESSION['email'])){
      require_once('./NotFound/index.php');
      die();
    }else{
      $MSKH = $isCustomer['MSKH'];
      $name = $isCustomer['HoTenKH'];
      $company = $isCustomer['TenCongTy'];
      $address = $userAddress['DiaChi'];
      $phone = $isCustomer['SoDienThoai'];
      $email = $isCustomer['Email'];
      $password = $isCustomer['PassWord'];
      $image = $isCustomer['Image'];
      if(!empty($_POST)){
        if(isset($_POST['name'])){
          $newName = str_replace('"','\\"',$_POST['name']);
        }
        if(isset($_POST['company'])){
          $newcompany = str_replace('"','\\"',$_POST['company']);
        }
        if(isset($_POST['address'])){
          $newAddress = str_replace('"','\\"',$_POST['address']);
        }
        if(isset($_POST['phone'])){
          $newPhone = str_replace('"','\\"',$_POST['phone']);
        }
        if(isset($_POST['email'])){
          $newemail = str_replace('"','\\"',$_POST['email']);
        }
        
        if(isset($_POST['password'])){
          $newpassword = str_replace('"','\\"',$_POST['password']);
        }

      
        if ($_FILES['uploadFile']['name'] !== '') {
            // check upload file
            if ($_FILES['uploadFile']['type'] === "image/jpeg" || $_FILES['uploadFile']['type'] === "image/png" || $_FILES['uploadFile']['type'] === "image/gif") {
                // Check Type
                $path = "img/"; 
                $tmp_name = $_FILES['uploadFile']['tmp_name'];
                $name = $_FILES['uploadFile']['name'];
                // move image to img folder
                move_uploaded_file($tmp_name, $path . $name);
                $image_url = $path . $name; // save path to database
              }
            else {
              $checkTypeFile = false;
            }
          }else{
            $checkSelectFile = false;
          }

        $yourphoneSql = 'select * from khachhang where SoDienThoai = "'.$newPhone.'" and MSKH = "'.$_GET['MSKH'].'"';
        $yourPhone = executeResultOne($yourphoneSql); 

        $oldPhoneSql = 'select * from khachhang where SoDienThoai = "'.$newPhone.'"';
        $oldPhone = executeResultOne($oldPhoneSql);

        $youremailSql = 'select * from khachhang where Email = "'.$newemail.'" and MSKH = "'.$_GET['MSKH'].'"';
        $yourEmail = executeResultOne($youremailSql); 

        $oldEmailSql = 'select * from khachhang where Email = "'.$newemail.'"';
        $oldEmail = executeResultOne($oldEmailSql);
        if((empty($oldPhone) || !empty($yourPhone))){
          if(!$checkTypeFile){
            echo '<div class="alert alert-danger alert-dismissible fade show position-absolute inform" role="alert">
                  Invalid file !
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
          }else if((empty($oldEmail) || !empty($yourEmail))){
            $sql = 'update khachhang set HoTenKH = "'.$newName.'", TenCongTy="'.$newcompany.'", 
            SoDienThoai="'.$newPhone.'", Email = "'.$newemail.'" ,PassWord="'.$isCustomer['PassWord'].'"
            where MSKH = "'.$isCustomer['MSKH'].'"';
            $updateAdressSql = 'update diachikh set DiaChi = "'.$newAddress.'" where MSKH = "'.$isCustomer['MSKH'].'"';
            if($checkSelectFile){
              $sqlImage = 'update khachhang set Image = "'.$image_url.'" where MSKH = "'.$MSKH.'"';
              execute($sqlImage);
            }
            execute($sql);
            execute($updateAdressSql);
            header("Refresh:0");
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
    }
  }else{
    require_once('./NotFound/index.php');
    die();
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
      content="Website b??n iphone v?? macbook uy t??n ch???t l?????ng cao"
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
    <link rel="stylesheet" href="./css/index.css" />
    <link
      href="./font-awesome/fontawesome-free-5.15.3-web/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./css/query.css" />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    <title>Th??ng tin c?? nh??n</title>
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

      .outline-phone{
        border-color: red !important;
      }

      .inform{
        top: 80px;
        right: 0;
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
                                      <div>S??? l?????ng: '.$_SESSION['product'][$index][1].' &nbsp;&nbsp;Gi??: '.number_format($_SESSION['product'][$index][1]*$currentProduct['GiamGia'], 0, '.', '.').'</div>
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
                            <div class="d-flex align-items-center mb-2 product-item pb-2">
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
    </header>

    <!-- ============================================== -->

    <!-- ====================Personal================== -->

    <div class="container mt-1 mb-5 d-flex">
        <div class="img-fluid d-none d-md-block w-75"><img src="<?=$image?>" alt="person" class="rounded-circle border shadow-lg bg-info rounded" width="300px" height="300px"></div>
        <form enctype="multipart/form-data" class="shadow p-2 bg-body rounded w-100 m-auto" method="POST">
          
          <div><h3 class="bg-info text-light text-center p-2">Th??ng tin c?? nh??n</h3></div>
          
          <div class="mb-2">
            <label for="name" class="form-label">H??? v?? T??n</label>
            <input type="text" class="form-control" id="name" name="name" value = "<?=$name?>" required>
          </div>
          <div class="mb-2">
            <label for="company" class="form-label">T??n C??ng Ty</label>
            <input type="text" class="form-control" id="company" name="company" value = "<?=$company?>" required>
          </div>
          <div class="mb-2">
            <label for="address" class="form-label">?????a ch???</label>
            <input type="text" class="form-control" id="address" name="address" value = "<?=$address?>" required>
          </div>
          <div class="mb-2">
            <label for="phone" class="form-label">S??? ??i???n tho???i</label>
            <?php
              if(empty($oldPhone) || $oldPhone['MSKH'] === $_GET['MSKH']){
                echo '<input type="tel" class="form-control" id="phone" pattern="0[0-9]{9}" name="phone" value = "'.$phone.'" required>';
              }else{
                echo '<input type="tel" class="form-control outline-phone" id="phone" pattern="0[0-9]{9}" name="phone" placeholder = "S??? ??i???n tho???i ???? t???n t???i" required>';
              }
            ?>
          </div>
          <div class="mb-2">
            <label for="email" class="form-label">Email</label>
            <?php
              if(empty($oldEmail)|| $oldEmail['MSKH'] === $_GET['MSKH']){
                echo '<input type="email" class="form-control" id="email" name="email" value = "'.$email.'" required>';
              }else{
                echo '<input type="email" class="form-control outline-phone" id="email" name="email" placeholder="Email ???? t???n t???i" required>';
              }
            ?>
          </div>
          <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" value = "<?=$password?>" required>
          </div>
          <div class="mb-2">
            <label for="file" class="form-label">Avatar</label>
            <input type="file" class="form-control form-control-sm" id="file" name="uploadFile" value = "Upload">
          </div>
          <button type="submit" name="submit" class="btn btn-info w-75 d-block m-auto mt-3 text-white" value="C???p nh???t th??ng tin">
            C???p nh???t th??ng tin
          </button>
        </form>
        </div>

    <!-- ============================================== -->
    <!-- =====================Footer=================== -->

    <footer>
      <div class="container d-block d-lg-flex register">
        <div class="icon">
          <img src="./img/newsletter.png" alt="letter-icon" />
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
              <h6>K???t n???i v???i ch??ng t??i</h6>
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
              <h6>T???i ???ng d???ng tr??n ??i???n tho???i</h6>
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
                >Gi???y ch???ng nh???n ????ng k?? Kinh doanh s??? 01122000 do S??? K??? ho???ch
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
        console.log('adad');
        $.post("/Resource/Logout/",{
          "message": "logout",
        },(data)=>{
          location.reload();
        });
      }

      const id = setTimeout(() => {
        const alertHtml = document.querySelector('.inform');
        alertHtml.style.display = 'none';
        clearTimeOut(id);
      }, 3000);
    </script>
  </body>
</html>
