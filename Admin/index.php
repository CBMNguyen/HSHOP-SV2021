<?php
  require_once('../Database/config.php');
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
    <title>Quản Lý Hàng Hóa</title>
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
        <a href="#"><span>💼</span>Quản lý Hàng Hóa</a>
      </li>
      <li>
        <a href="/Resource/Admin/Typeofgoods"><span>🎎</span>Quản lý Loại Hàng Hóa</a>
      </li>
      <li>
        <a href="/Resource/Admin/Order"><span>🛒</span>Quản lý Đặt Hàng</a>
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
            <img src="../<?=$avt_url?>" alt="HN">
            <span><strong>Admin</strong></span>
          </a>
        </li>
      </ul>

      <div class="container">
        <div class="d-flex align-items-center">
          <a class="btn add-btn mt-2 mb-2" href="/Resource/Admin/UpdateData?type=1">New Phone</a>
          <a class="btn add-btn ms-2 mt-2 mb-2" href="/Resource/Admin/UpdateData?type=2">New Laptop</a>
          <nav aria-label="Page navigation example" class="d-block ms-auto">
            <ul class="pagination m-0 p-0 mt-1">
              <?php
                $sql = 'select * from hanghoa';
                $result = executeResult($sql);

                if(empty($_GET)){
                  if(!isset($_GET['page'])){
                    $_SESSION['page'] = 1;
                  }
                }else{
                  if(isset($_GET['page'])){
                    $_SESSION['page'] = $_GET['page'];
                  }
                }

                $isBack = '';
                $isContinue = '';
                if($_SESSION['page'] <= 1){
                  $isBack = 'disabled';
                }

                if($_SESSION['page'] >= ceil(count($result)/8.0)){
                  $isContinue = 'disabled';
                }

                echo '
                  <li class="page-item '.$isBack.'">
                    <a class="page-link bg-info" href="/Resource/Admin/index.php?page='.$_SESSION['page'] - 1 .'" aria-label="Previous">
                      <span class="text-white" aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                ';
                 for ($i = 1; $i <= ceil(count($result)/8.0); $i++){
                   echo '
                    <li class="page-item"><a class="page-link" href="/Resource/Admin/index.php?page='.$i.'">'.$i.'</a></li>
                   ';
                 }

                 echo '
                  <li class="page-item '.$isContinue.'">
                    <a class="page-link bg-info" href="/Resource/Admin/index.php?page='.$_SESSION['page'] + 1 .'" aria-label="Next">
                      <span class="text-white" aria-hidden="true">&raquo;</span>
                    </a>
                  </li>';
              ?>
            </ul>
          </nav>
        </div>
        <table id="myTable" class="table table-sm table-hover shadow p-3 m-0 bg-body rounded">
          <tr class="table-info">
            <th>STT</th>
            <th>Hình Ảnh</th>
            <th>Tên Hàng Hóa</th>
            <th>Giá</th>
            <th>Giảm Giá</th>
            <th>Trả Góp</th>
            <th>Số Lượng</th>
            <th>Ram</th>
            <th>Ngày Tạo</th>
            <th>Ngày Cập Nhật</th>
            <th>Chức Năng</th>
          </tr>
            <?php
              $sql = 'select * from hanghoa';
              $result = executeResult($sql);
              $Stt = 0;
              $result = array_slice($result, ($_SESSION['page'] - 1) * 8, 8);
              foreach($result as $product){
                $Stt++;
                if(substr($product['thumbnail'],0, 2) === './'){
                  $src = "../".$product['thumbnail'];
                }else{
                  $src = $product['thumbnail'];
                }
                echo '
                  <tr>
                    <td>'.$Stt + ($_SESSION['page'] - 1) * 8 .'</td>
                    <td><img src="'.$src.'" alt="#"></td>
                    <td class="a">'.$product['TenHH'].'</td>
                    <td>'.number_format($product['Gia'], 0, '.', '.').'</td>
                    <td>'.number_format($product['GiamGia'], 0, '.', '.').'</td>
                    <td>'.$product['TraGop'].'%</td>
                    <td>'.$product['SoLuongHang'].'</td>
                    <td>'.$product['Ram'].'</td>
                    <td>'.$product['Created_at'].'</td>
                    <td>'.$product['Updated_at'].'</td>
                    <td>
                      <a href="/Resource/Admin/UpdateData/?productId= '.$product['MSHH'].'&type='.$product['MaLoaiHang'].'" class="btn btn-info text-light">Sửa</a>
                      <a class="btn btn-warning text-light" onclick="deleteProduct(this.id)" id="'.$product['MSHH'].'">Xóa</a>
                    </td>
                  </tr>
                ';
              }
            ?>
        </table>
      </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      function deleteProduct(productId){
        const check = confirm(`Bạn có chắc muốn xóa hàng hóa với MSHH = "${productId}"`);
        if(!check) return;
        $.post("UpdateData/delete.php",{
          "productId": productId,
        },(data)=>{
          location.reload();
        });
      };
    </script>
    <script>
      function searchPhone() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[2];
          if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }
        }
      }
</script>
  </body>
</html>
