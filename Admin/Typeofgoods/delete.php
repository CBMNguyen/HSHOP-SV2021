<?php
  require_once('../../Database/config.php');
  if(!empty($_POST)){
    if(isset($_POST['MLHH'])){
      $MLHH = $_POST['MLHH'];

      $sql = 'delete from loaihanghoa where MaLoaiHang = "'.$MLHH.'"';
      execute($sql);
    }
  }