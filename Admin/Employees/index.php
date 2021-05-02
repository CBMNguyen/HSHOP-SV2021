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
    <link rel="stylesheet" href="./indexx.css" />
    <title>Quản Lý Nhân Viên</title>
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
        <a href="#"><span>👨‍✈️</span>Quản lý Nhân Viên</a>
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
      <li>
        <a href="/Resource/Admin/Order"><span>🛒</span>Quản lý Giỏ Hàng</a>
      </li>
      <li>
        <a href="/Resource/Admin/Revenue"><span>💳</span>Thống kê Doanh Thu</a>
      </li>
    </ul>

    <div class="main">
      <ul class="nav justify-content-end nav-menu">
      <form class="d-flex me-auto">
        <input id="myInput" onkeyup="searchNameEmployee()"  class="form-control me-2" type="search" placeholder="Tìm nhân viên theo tên" aria-label="Search">
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
        <a href = "/Resource/Admin/Employees/update.php" class="btn add-btn">Thêm Nhân Viên</a>
        <table id="myTable" class="table table-sm table-hover shadow p-3 mb-5 bg-body rounded">
          <tr class="table-info">
            <th>Id</th>
            <th>Họ Tên</th>
            <th>Lương</th>
            <th>Chức Vụ</th>
            <th>Địa Chỉ</th>
            <th>Email</th>
            <th>Số Điện Thoại</th>
            <th>Chức Năng</th>
          </tr>
            <?php
              $sql = 'select * from nhanvien ';
              $result = executeResult($sql);
              foreach($result as $person){
                echo '
                  <tr>
                    <td>'.$person['MSNV'].'</td>
                    <td>'.$person['HoTenNV'].'</td>
                    <td>'.number_format($person['Luong'], 0, '.', '.').'</td>
                    <td>'.$person['ChucVu'].'</td>
                    <td>'.$person['DiaChi'].'</td>
                    <td>'.$person['Email'].'</td>
                    <td>'.$person['SoDienThoai'].'</td>
                    <td>
                      <a href="/Resource/Admin/Employees/update.php?MSNV='.$person['MSNV'].'" class="btn btn-info text-light">Sửa</a>
                      <a onclick="deleteEmployee(this.id)" id="'.$person['MSNV'].'" class="btn btn-warning text-light">Xóa</a>
                    </button></td>
                  </tr>
                ';
              }
            ?>
        </table>
      </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      function deleteEmployee(MSNV){
        const check = confirm(`Bạn có chắc muốn nhân viên với id = "${MSNV}"`);
        if(!check) return;
        $.post("delete.php",{
          "MSNV": MSNV,
        },(data)=>{
          location.reload();
        });
      };

      function searchNameEmployee() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[1];
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
