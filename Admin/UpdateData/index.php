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

  $isrequire = 'required';

  if(!empty($_GET)){
    if(isset($_GET['productId'])){
      $isrequire = '';
    }
  }

  if(!empty($_POST)){
    $checkTypeFile = true;
    $image_url = '';
    if ($_FILES['uploadFile']['name'] !== '') {
      // check upload file
      if ($_FILES['uploadFile']['type'] === "image/jpeg" || $_FILES['uploadFile']['type'] === "image/png" || $_FILES['uploadFile']['type'] === "image/gif") {
          // Check Type
          $path = "./img/"; 
          $tmp_name = $_FILES['uploadFile']['tmp_name'];
          $name = $_FILES['uploadFile']['name'];
          // move image to img folder
          move_uploaded_file($tmp_name, $path . $name);
          $image_url = $path . $name; // save path to database
        }
      else {
        $checkTypeFile = false;
      }
    }

    if(!empty($_GET)){
      if($_GET['type'] === '1' && !isset($_GET['productId'])){
        if($checkTypeFile){
          $sql = 'insert into hanghoa values (
            "'.str_replace('"','\\"',$_POST['MSHH']).'", 
            "'.str_replace('"','\\"',$_POST['TenHH']).'", "", 
            "'.str_replace('"','\\"',$_POST['Gia']).'", 
            "'.str_replace('"','\\"',$_POST['SoLuongHang']).'",
            "'.str_replace('"','\\"',$_POST['MaLoaiHang']).'", 
            "'.str_replace('"','\\"',$_POST['ScreenSize']).'", 
            "'.str_replace('"','\\"',$_POST['Chip']).'", 
            "'.str_replace('"','\\"',$_POST['Ram']).'", 
            "'.str_replace('"','\\"',$_POST['Rom']).'", 
            "'.str_replace('"','\\"',$_POST['CamTR']).'", 
            "'.str_replace('"','\\"',$_POST['CamS']).'", 
            "'.str_replace('"','\\"',$_POST['Pin']).'", 
            "'.str_replace('"','\\"',$_POST['CapSac']).'", "", "", "", 
            "'.str_replace('"','\\"',$_POST['TraGop']).'", 
            "'.str_replace('"','\\"',$_POST['GiamGia']).'", "" , 
            "'.$image_url.'", "'.date("Y-m-d").'", "'.date("Y-m-d").'",
            "'.str_replace('"','\\"',$_POST['HeDieuHanh']).'", 
            "'.str_replace('"','\\"',$_POST['Sim']).'", 
            "'.str_replace('"','\\"',$_POST['ScreenTech']).'", "", 
            "'.str_replace('"','\\"',$_POST['Design']).'"
          )';
          execute($sql);
          header('location: /Resource/Admin');
          die();
        }else{
          echo '<div class="alert alert-danger alert-dismissible fade show position-absolute inform" role="alert">
                  Invalid file !
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } 
      }else if($_GET['type'] === '2' && !isset($_GET['productId'])){
        if($checkTypeFile){
          $sql = 'insert into hanghoa values (
            "'.str_replace('"','\\"',$_POST['MSHH']).'", 
            "'.str_replace('"','\\"',$_POST['TenHH']).'", "", 
            "'.str_replace('"','\\"',$_POST['Gia']).'", 
            "'.str_replace('"','\\"',$_POST['SoLuongHang']).'",
            "'.str_replace('"','\\"',$_POST['MaLoaiHang']).'", 
            "'.str_replace('"','\\"',$_POST['ScreenSize']).'", 
            "'.str_replace('"','\\"',$_POST['Chip']).'", 
            "'.str_replace('"','\\"',$_POST['Ram']).'", 
            "", 
            "", 
            "", "", 
            "", "'.str_replace('"','\\"',$_POST['Ssd']).'", 
            "'.str_replace('"','\\"',$_POST['DoHoa']).'", 
            "'.str_replace('"','\\"',$_POST['ThoiLuongPin']).'", 
            "'.str_replace('"','\\"',$_POST['TraGop']).'", 
            "'.str_replace('"','\\"',$_POST['GiamGia']).'", 
            "'.str_replace('"','\\"',$_POST['TrongLuong']).'" , 
            "'.$image_url.'", "'.date("Y-m-d").'", "'.date("Y-m-d").'",
            "'.str_replace('"','\\"',$_POST['HeDieuHanh']).'", 
            "", 
            "'.str_replace('"','\\"',$_POST['ScreenTech']).'", 
            "'.str_replace('"','\\"',$_POST['ScreenCard']).'", 
            "'.str_replace('"','\\"',$_POST['Design']).'"
          )';
          execute($sql);
          header('location: /Resource/Admin');
          die();
        }else{
          echo '<div class="alert alert-danger alert-dismissible fade show position-absolute inform" role="alert">
                  Invalid file !
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } 
      }
    }

    if(!empty($_GET)){
      if(isset($_GET['productId'])){
        $sqlFindProduct = 'select * from hanghoa where hanghoa.MSHH = "'.str_replace(' ','',$_GET['productId']).'"';
        $FindProduct = executeResultOne($sqlFindProduct);
        if($_FILES['uploadFile']['name'] === ''){
          $image_url = $FindProduct['thumbnail'];
        }
        if(!empty($FindProduct) && $FindProduct['MaLoaiHang'] === '1'){
          if($checkTypeFile){
            $updateProduct = 'update hanghoa set TenHH = "'.str_replace('"','\\"',$_POST['TenHH']).'",
            QuyCach = "'.str_replace('"','\\"',$_POST['QuyCach']).'",
            Gia = "'.str_replace('"','\\"',$_POST['Gia']).'",
            SoLuongHang = "'.str_replace('"','\\"',$_POST['SoLuongHang']).'",
            MaLoaiHang = "'.str_replace('"','\\"',$_POST['MaLoaiHang']).'", 
            ScreenSize = "'.str_replace('"','\\"',$_POST['ScreenSize']).'",
            Chip =  "'.str_replace('"','\\"',$_POST['Chip']).'", 
            Ram = "'.str_replace('"','\\"',$_POST['Ram']).'", 
            Rom = "'.str_replace('"','\\"',$_POST['Rom']).'",
            CamTR = "'.str_replace('"','\\"',$_POST['CamTR']).'", 
            CamS = "'.str_replace('"','\\"',$_POST['CamS']).'",
            Pin = "'.str_replace('"','\\"',$_POST['Pin']).'",
            CapSac = "'.str_replace('"','\\"',$_POST['CapSac']).'",
            Ssd = "", 
            DoHoa = "",
            ThoiLuongPin = "",
            TraGop = "'.str_replace('"','\\"',$_POST['TraGop']).'",
            GiamGia =  "'.str_replace('"','\\"',$_POST['GiamGia']).'",
            TrongLuong = "",
            thumbnail = "'.$image_url.'",
            Created_at = "'.$FindProduct['Created_at'].'",
            Updated_at = "'.date("Y-m-d").'",
            HeDieuHanh = "'.str_replace('"','\\"',$_POST['HeDieuHanh']).'", 
            Sim = "'.str_replace('"','\\"',$_POST['Sim']).'",
            ScreenTech = "'.str_replace('"','\\"',$_POST['ScreenTech']).'",
            ScreenCard = "",
            Design = "'.str_replace('"','\\"',$_POST['Design']).'"
            where MSHH = "'.str_replace(' ','',$_GET['productId']).'"
            ';
            execute($updateProduct);
            header('location: /Resource/Admin');
            die();
          }else{
            echo '<div class="alert alert-danger alert-dismissible fade show position-absolute inform" role="alert">
                  Invalid file !
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
          }
        }else if(!empty($FindProduct) && $FindProduct['MaLoaiHang'] === '2'){
          if($checkTypeFile){
            $updateProduct = 'update hanghoa set MSHH = TenHH = "'.str_replace('"','\\"',$_POST['TenHH']).'",
            QuyCach = "'.str_replace('"','\\"',$_POST['QuyCach']).'",
            Gia = "'.str_replace('"','\\"',$_POST['Gia']).'",
            SoLuongHang = "'.str_replace('"','\\"',$_POST['SoLuongHang']).'",
            MaLoaiHang = "'.str_replace('"','\\"',$_POST['MaLoaiHang']).'", 
            ScreenSize = "'.str_replace('"','\\"',$_POST['ScreenSize']).'",
            Chip =  "'.str_replace('"','\\"',$_POST['Chip']).'", 
            Ram = "'.str_replace('"','\\"',$_POST['Ram']).'", 
            Rom = "",
            CamTR = "", 
            CamS = "",
            Pin = "",
            CapSac = "",
            Ssd = "'.str_replace('"','\\"',$_POST['Ssd']).'", 
            DoHoa = "'.str_replace('"','\\"',$_POST['DoHoa']).'",
            ThoiLuongPin = "'.str_replace('"','\\"',$_POST['ThoiLuongPin']).'",
            TraGop = "'.str_replace('"','\\"',$_POST['TraGop']).'",
            GiamGia =  "'.str_replace('"','\\"',$_POST['GiamGia']).'",
            TrongLuong = "'.str_replace('"','\\"',$_POST['TrongLuong']).'",
            thumbnail = "'.$image_url.'",
            Created_at = "'.date("Y-m-d").'",
            Updated_at = "'.date("Y-m-d").'",
            HeDieuHanh = "'.str_replace('"','\\"',$_POST['HeDieuHanh']).'", 
            Sim = "",
            ScreenTech = "'.str_replace('"','\\"',$_POST['ScreenTech']).'",
            ScreenCard = "'.str_replace('"','\\"',$_POST['ScreenCard']).'",
            Design = "'.str_replace('"','\\"',$_POST['Design']).'"
            where MSHH = "'.str_replace(' ','',$_GET['productId']).'"
            ';
            execute($updateProduct);
            header('location: /Resource/Admin');
            die();
          }else{
            echo '<div class="alert alert-danger alert-dismissible fade show position-absolute inform" role="alert">
                  Invalid file !
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
          }
      }
      }
    }
  }
  


  // ===========================================================
  $phone = false;
  $productId = false;
  $Product = null;

  $MSHH = $TenHH = $QuyCach = $Gia = $SoLuongHang = $MaLoaiHang = $ScreenSize = $Chip = $Ram = $Rom = $CamTR = $CamS = $Pin = $CapSac = $Ssd = $DoHoa = $ThoiLuongPin = $TraGop = $GiamGia = $TrongLuong = $thumbnail = $Created_at = $Updated_at = $HeDieuHanh = $Sim = $ScreenTech = $ScreenCard = $Design = '';

  if(!empty($_GET)){
    if(isset($_GET['type']) && $_GET['type'] === '1'){
      $phone = true;
    }

    if(isset($_GET['productId'])){
      $sqlFindProduct = 'select * from hanghoa where hanghoa.MSHH = "'.str_replace(' ','',$_GET['productId']).'"';
      if(!empty($sqlFindProduct)){
        $productId = true;
        $Product = executeResult($sqlFindProduct);
        if(!empty($Product)){
          $MSHH = $Product[0]['MSHH'];
          $TenHH = $Product[0]['TenHH'];
          $QuyCach = $Product[0]['QuyCach'];
          $Gia = $Product[0]['Gia'];
          $SoLuongHang = $Product[0]['SoLuongHang'];
          $MaLoaiHang = $Product[0]['MaLoaiHang'];
          $ScreenSize = $Product[0]['ScreenSize'];
          $Chip = $Product[0]['Chip'];
          $Ram = $Product[0]['Ram'];
          $Rom = $Product[0]['Rom'];
          $CamTR = $Product[0]['CamTR'];
          $CamS = $Product[0]['CamS'];
          $Pin = $Product[0]['Pin'];
          $CapSac = $Product[0]['CapSac'];
          $Ssd = $Product[0]['Ssd'];
          $DoHoa = $Product[0]['DoHoa'];
          $ThoiLuongPin = $Product[0]['ThoiLuongPin'];
          $TraGop = $Product[0]['TraGop'];
          $GiamGia = $Product[0]['GiamGia'];
          $TrongLuong = $Product[0]['TrongLuong'];
          $thumbnail = $Product[0]['thumbnail'];
          $Created_at = $Product[0]['Created_at'];
          $Updated_at = date("Y-m-d");
          $HeDieuHanh = $Product[0]['HeDieuHanh'];
          $Sim = $Product[0]['Sim'];
          $ScreenTech = $Product[0]['ScreenTech'];
          $ScreenCard = $Product[0]['ScreenCard'];
          $Design = $Product[0]['Design'];
        }
      }
    }

  }else{
    echo require_once('../../NotFound/index.php');
      die();
  }

  if(empty($_POST)){
    if(($_GET['type'] !== '1' && $_GET['type'] !== '2') && $productId === false){
      echo require_once('../../NotFound/index.php');
      die();
    }
    if($productId){
      $_GET['type'] = null;
    }
    
    if(($_GET['type'] !== '1' && $_GET['type'] !== '2') && $productId === false){
      echo require_once('../../NotFound/index.php');
      die();
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
              if(isset($_GET['productId'])){
                echo  '
                  Cập nhật hàng hóa
                ';
              }else{
                echo '
                  Thêm hàng hóa
                ';
              }
      ?>
    </title>
    <style>
      .inform{
        top: 80px;
        right: 0;
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
        <div class="row mt-3 mb-2">
          <div class="col"><h3 class="bg-info text-light text-center p-2">Thông tin hàng hóa</h3></div>
          <div class="col"><h3 class="bg-warning text-light text-center p-2">Thông số kỹ thuật</h3></div>
        </div>
        <form enctype="multipart/form-data" class="container-fluid shadow p-4 bg-body rounded" method="POST">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="group">
                <div>
                  <div><label>Mã số hàng hóa</label></div>
                  <div>
                    <?php 
                      if(isset($_GET['productId'])){
                        echo  '
                          <input class="form-control w-100" type="text" name = "MSHH" required value="'.$MSHH.'" disabled>
                        ';
                      }else{
                        echo '
                          <input class="form-control w-100" type="text" name = "MSHH" required value="'.$MSHH.'" >
                        ';
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Tên hàng hóa</label></div>
                  <div><input class="form-control" type="text" name="TenHH" required value="<?=$TenHH?>"></div>
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Mã loại hàng hóa</label></div>
                  <div>
                    <select class='form-control' name="MaLoaiHang" aria-label="Default select example">
                    <?php 
                  if($phone === false){
                    echo '<option selected>2</option>';
                    echo '<option value="1">1</option>';
                  }else{
                    echo '<option selected>1</option>';
                    echo '<option value="2">2</option>';
                  }
                    ?> 
                      
                  </select>
                  </div>
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Số lượng hàng hóa</label></div>
                  <div>
                    <input class='form-control' type="number" 
                    name="SoLuongHang" 
                    required value="<?=$SoLuongHang?>"
                    min="0" max="99"
                    >
                  </div>
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Giá</label></div>
                  <div><input class='form-control' type="text" name="Gia" required value="<?=$Gia?>"></div>
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Giảm giá</label></div>
                  <div><input class="form-control" type="text" name = "GiamGia" required value="<?=$Gia?>"></div>
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Trả góp</label></div>
                  <div><input class="form-control" type="text" name="TraGop" required value="<?=$TraGop?>"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="group">
              <div>
                <div><label>Hình ảnh</label></div>
                <div><input class="form-control form-control-sm" type="file" name="uploadFile" value="upload" <?=$isrequire?>></div>
              </div>
            </div>
              <div class="group">
                <div>
                  <div><label>Thiết kế</label></div>
                  <div><input class='form-control' type="text" name="Design" required value="<?=$Design?>"></div>
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Cáp sạc</label></div>
                  <?php 
                  if($phone === false){
                    echo '<div><input class="form-control" type="text" name = "CapSac" required disabled value="'.$CapSac.'"></div>';
                  }else{
                    echo '<div><input class="form-control" type="text" name = "CapSac" required value="'.$CapSac.'"></div>';
                  }
                    ?> 
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Quy cách</label></div>
                  <div><input class='form-control' type="text" name="QuyCach" value="<?=$QuyCach?>"></div>
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Pin</label></div>
                  <?php 
                  if($phone === false){
                    echo '<div><input class="form-control" type="text" name = "Pin" required disabled value="'.$Pin.'"></div>';
                  }else{
                    echo '<div><input class="form-control" type="text" name = "Pin" required value="'.$Pin.'"></div>';
                  }
                    ?> 
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Sim</label></div>
                  <?php 
                  if($phone === false){
                    echo '<div><input class="form-control" type="text" name = "Sim" required disabled value="'.$Sim.'" ></div>';
                  }else{
                    echo '<div><input class="form-control" type="text" name = "Sim" required value="'.$Sim.'" ></div>';
                  }
                    ?> 
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Hệ điều hành</label></div>
                  <div><input class="form-control" type="text" name="HeDieuHanh" required value="<?=$HeDieuHanh?>"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="group">
                <div>
                  <div><label >Camera trước</label></div>
                  <?php 
                  if($phone === false){
                    echo '<div><input class="form-control" type="text" name = "CamTR" required disabled value="'.$CamTR.'"></div>';
                  }else{
                    echo '<div><input class="form-control" type="text" name = "CamTR" required value="'.$CamTR.'"></div>';
                  }
                    ?> 
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Camera sau</label></div>
                  <?php 
                  if($phone === false){
                    echo '<div><input class="form-control" type="text" name = "CamS" required disabled value="'.$CamS.'"></div>';
                  }else{
                    echo '<div><input class="form-control" type="text" name = "CamS" required value="'.$CamS.'"></div>';
                  }
                    ?> 
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Rom</label></div>
                  <div>
                  <?php 
                  if($phone === false){
                    echo '<select class="form-control" name="Rom" aria-label="Default select example" disabled >
                            <option selected>32GB</option>
                            <option value="64 GB">64GB</option>
                            <option value="128 GB">128GB</option>
                            <option value="256 GB">256GB</option>
                            <option value="512 GB ">512GB</option>
                        </select>';
                  }else{
                    echo '<select class="form-control" name="Rom" aria-label="Default select example">
                            <option selected>32GB</option>
                            <option value="64 GB">64GB</option>
                            <option value="128 GB">128GB</option>
                            <option value="256 GB">256GB</option>
                            <option value="512 GB ">512GB</option>
                        </select>';
                  }
                    ?> 
                  </div>
                  </div>
              </div>
              <div class="group">
                <div>
                  <div><label for="">Ram</label></div>
                  <div>
                  <select class="form-control" name="Ram" aria-label="Default select example">
                    <option selected>3GB</option>
                    <option value="4 GB">4GB</option>
                    <option value="6 GB">6GB</option>
                    <option value="8 GB">8GB</option>
                    <option value="16 GB ">16GB</option>
                </select>
                  </div>
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Kích thước màn hình</label></div>
                  <div><input class="form-control" type="text" name = "ScreenSize" required value="<?=$ScreenSize?>"></div>
                </div>
              </div>
              <div class="group">
                <div>
                  <div><label>Công nghệ màn hình</label></div>
                  <div><input class="form-control" type="text" name="ScreenTech" required value="<?=$ScreenTech?>"></div>
                </div>
              </div>  
              <div class="group">
                <div>
                  <div><label>Chip</label></div>
                  <div><input class="form-control" type="text" name="Chip" required value="<?=$Chip?>"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="group">
              <div>
                <div><label>Trọng lượng</label></div>
                <?php 
                if($phone === true){
                  echo '<div><input class="form-control" type="text" name = "TrongLuong" required disabled value="'.$TrongLuong.'"></div>';
                }else{
                  echo '<div><input class="form-control" type="text" name = "TrongLuong" required value="'.$TrongLuong.'" ></div>';
                }
                  ?> 
              </div>
            </div>
                <div class="group">
                  <div>
                    <div><label>Thời lượng pin</label></div>
                    <?php 
                    if($phone === true){
                      echo '<div><input class="form-control" type="text" name = "ThoiLuongPin" required disabled value="'.$ThoiLuongPin.'" ></div>';
                    }else{
                      echo '<div><input class="form-control" type="text" name = "ThoiLuongPin" required value="'.$ThoiLuongPin.'" ></div>';
                    }
                      ?> 
                  </div>
                </div>
                <div class="group">
                  <div>
                    <div><label>Ổ cứng SSD</label></div>
                    <?php 
                    if($phone === true){
                      echo '<div><input class="form-control" type="text" name = "Ssd" required disabled value="'.$ThoiLuongPin.'" ></div>';
                    }else{
                      echo '<div><input class="form-control" type="text" name = "Ssd" required value="'.$ThoiLuongPin.'" ></div>';
                    }
                      ?> 
                  </div>
                </div>
                <div class="group">
                  <div>
                    <div><label>Card màn hình</label></div>
                    <?php 
                    if($phone === true){
                      echo '<div><input class="form-control" type="text" name = "ScreenCard" required disabled value="'.$ScreenCard.'" ></div> ';
                    }else{
                      echo '<div><input class="form-control" type="text" name = "ScreenCard" required value="'.$ScreenCard.'" ></div>';
                    }
                      ?> 
                  </div>
                </div>
                <div class="group">
                  <div>
                    <div><label>Đồ họa</label></div>
                    <?php 
                    if($phone === true){
                      echo '<div><input class="form-control" type="text" name = "DoHoa" required disabled value="'.$DoHoa.'" ></div>';
                    }else{
                      echo '<div><input class="form-control" type="text" name = "DoHoa" required value="'.$DoHoa.'" ></div>';
                    }
                      ?> 
                  </div>
                </div>
              </div>
          </div>
          <button class="btn btn-danger d-block w-50 m-auto mt-3 goods-btn"><h4>
          <?php 
              if(isset($_GET['productId'])){
                echo  '
                  Cập nhật hàng hóa
                ';
              }else{
                echo '
                  Thêm hàng hóa
                ';
              }
            ?>
          </h4></button>
        </div>
          
        </form>
      </div>
    </div>
    <script>
       const id = setTimeout(() => {
        const alertHtml = document.querySelector('.inform');
        alertHtml.style.display = 'none';
        clearTimeOut(id);
      }, 3000);
    </script>
  </body>
</html>
